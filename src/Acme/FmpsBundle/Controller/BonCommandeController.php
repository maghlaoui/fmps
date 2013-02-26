<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\BonCommande;
use Acme\FmpsBundle\Entity\ArticleBonCommande;
use Acme\FmpsBundle\Entity\Facture;
use Acme\FmpsBundle\Form\BonCommandeType;
use Symfony\Component\HttpFoundation\Response;
use Acme\FmpsBundle\Util\ChiffreEnLettre;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * BonCommande controller.
 *
 * @Route("/bons_commande")
 */
class BonCommandeController extends Controller
{
    /**
     * Lists all BonCommande entities.
     *
     * @Route("/", name="boncommande")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('AcmeFmpsBundle:BonCommande');

        $paginator = $this->get('knp_paginator');
        $searchValues = new BonCommande();
        $searchValues->setStatus(null);
        $request = $this->getRequest();
        $anneeBc = $request->get('anneeBc');
        if ( empty($anneeBc)  ) $anneeBc = Date('Y');
        $status = $request->get('status');
			  $page = $this->get('request')->query->get('page', 1);
        if ( !empty($anneeBc) ) $searchValues->setAnneeBc($anneeBc);
        if ( !empty($status) ) $searchValues->setStatus($status);
        $form = $this->getForm($searchValues);
				$form->bindRequest($request);
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,500);
        
        
        if ($request->getRequestFormat() == 'pdf'){
	          $data =  array('entities' => $entities);
            $html = $this->renderView('AcmeFmpsBundle:BonCommande:index.pdf.twig', $data);
		        $file = 'liste_des_bon_commande.pdf';
		
            return $this->get('io_tcpdf')->quick_pdf($html, $file);
        }
        
        return $this->render('AcmeFmpsBundle:BonCommande:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a BonCommande entity.
     *
     * @Route("/{id}/show", name="boncommande_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('AcmeFmpsBundle:BonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonCommande entity.');
        }
        
        $repository = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande');
        
        $articles   = $repository->getArticles($entity);
        $total      = $repository->getTotalBonCommande($id) * $entity->getRemiseFor();
        $tva        = $repository->getArticlesGroupedByTva($entity);
        
        $bons_livraison = $entity->getBonsLivraison();
        
        if ($entity->getId() != null){
            $repository = $em->getRepository('AcmeFmpsBundle:Facture');
            $facture    = $repository->getOneByBonCommandeId($entity->getId());
        }
        else{
            $facture = null;
        }
        
        if ($total == null) $total = 0;
        $deleteForm = $this->createDeleteForm($id);
        try{
            $converter = new ChiffreEnLettre();
            $total_str = $converter->ConvNumberLetter(number_format($total, 2, '.', ''),1,0);
        }
        catch (Exception $e) {
            //$total_str = $e->getMessage();
        }
        
        $request = $this->getRequest();
        
        $data =  array(
            'entity'      => $entity,
            'total_str'   => $total_str,
            'total'       => $total,
            'groupe_tva'  => $tva,
            'articles'    => $articles );
        
        if ($request->getRequestFormat() == 'pdf'){
            $html = $this->renderView('AcmeFmpsBundle:BonCommande:show.pdf.twig', $data);
		        $file = 'bon_commande_'.$entity->getNumero().'.pdf';
		
            return $this->get('io_tcpdf')->quick_pdf($html, $file);
        }
        
        return array(
            'entity'      => $entity,
            'total_str'   => $total_str,
            'total'       => $total,
            'groupe_tva'  => $tva,
            'articles'    => $articles,
            'bons_livraison' => $bons_livraison,
            'facture'      => $facture,
            'delete_form' => $deleteForm->createView(), );
    }

    /**
     * Displays a form to create a new BonCommande entity.
     *
     * @Route("/new", name="boncommande_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BonCommande();
        $form   = $this->createForm(new BonCommandeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new BonCommande entity.
     *
     * @Route("/create", name="boncommande_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:BonCommande:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new BonCommande();
        $request = $this->getRequest();
        $form    = $this->createForm(new BonCommandeType(), $entity);
        $form->bindRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setStatus('engagé');
            $entity->setAnneeBc($entity->getDateBc()->format('Y'));
            
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Bon de commande a été créé avec succès');

            return $this->redirect($this->generateUrl('boncommande_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing BonCommande entity.
     *
     * @Route("/{id}/edit", name="boncommande_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:BonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonCommande entity.');
        }

        $editForm = $this->createForm(new BonCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BonCommande entity.
     *
     * @Route("/{id}/update", name="boncommande_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:BonCommande:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:BonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonCommande entity.');
        }
        
        $editForm   = $this->createForm(new BonCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {

            $entity->setAnneeBc($entity->getDateBc()->format('Y'));
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Bon de commande a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('boncommande_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BonCommande entity.
     *
     * @Route("/{id}/delete", name="boncommande_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('AcmeFmpsBundle:BonCommande');
            $entity = $repository->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BonCommande entity.');
            }

            $em->remove($entity);
            $em->flush();
            $repository->deleteFacture($id);

						$this->get('session')->setFlash('notice', 'Bon de commande a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('boncommande'));
    }  
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

	private function getForm($searchValues)
	{
		$qb = $this->createFormBuilder( $searchValues );
	
								$qb->add('fournisseur', 'entity', array('class' => 'AcmeFmpsBundle:Fournisseur', 'empty_value' => '--Sélectionnez--', 'required'  => false, 'attr' => array('class' => 'input-medium'), 
		                'query_builder' => function (EntityRepository $er)
		                     {
		                         return $er->createQueryBuilder('f')->addOrderBy('f.nom', 'ASC');
		                     }
		                     ));
                $qb->add('status', 'choice', array('choices' => BonCommande::getDefaultStatus(), 'required'  => false, 'empty_value' => '--Sélectionnez--', 'attr' => array('class' => 'input-medium')))
                ->add("anneeBc", "choice", array('label' => 'Année', 'choices' => FmpsLists::getDefaultYears(), 'empty_value' => '--Sélectionnez--', 'required' => false, 'attr' => array('class' => 'span2')))
                ->add("dateBc", "date", array('label' => 'Du', 'required'  => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date span2')))
                ->add("updatedAt", "date", array('label' => 'Au', 'required'  => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date span2')));
                
			return $qb->getForm();
	}

    /**
     * show stats about BonCommande entities.
     *
     * @Route("/stats", name="boncommande_stats")
     * @Template()
     */
    public function statsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('AcmeFmpsBundle:BonCommande')->getGroupedStatsByYear();
        $stats = array();
        $pie_data = array(0.00, 0.00);

        foreach ($entities as $entity){
            $anneeBc = $entity['anneeBc'];
            $status = $entity['status'];
            $total = $entity['total'];
   
            if (!array_key_exists($anneeBc, $stats)) $stats[$anneeBc] = array(0.00, 0.00);
            $request = $this->getRequest();
            $postData = $request->request->get('form');
            $panneeBc = $postData['anneeBc'];

            if ( empty($panneeBc) ){
                $panneeBc = $request->get('anneeBc');
            }
       
            if ($status == 'engagé'){
                $stats[$anneeBc][0] = $total;
                if ($panneeBc == '' || $panneeBc == $anneeBc) $pie_data[0] += $total;
            } 
            else if ($status == 'payé'){
                $stats[$anneeBc][1] = $total;
                if ($panneeBc == '' || $panneeBc == $anneeBc) $pie_data[1] += $total;
            }
           
        }
        $bc = new BonCommande();
        $bc->setAnneeBc($panneeBc);
        $form = $this->createFormBuilder( $bc )
                ->add('anneeBc', 'choice', array('choices' => FmpsLists::getDefaultYears(), 'empty_value' => '--Sélectionnez--', 'required'  => false))
                ->add('bc', 'checkbox', array('property_path' => false, 'attr' => array('checked' => 'checked', 'disabled' => true)))
                ->add('marche', 'checkbox', array('property_path' => false, 'attr' => array('disabled' => true)))
                ->add('contrat', 'checkbox', array('property_path' => false, 'attr' => array('disabled' => true)))
                ->getForm();

        if ($request->getRequestFormat() == 'pdf'){
            $vals = array(array(), array());
            $years = array_keys($stats);
            foreach ($stats as $stat){
                $vals[0][] = $stat[0];
                $vals[1][] = $stat[1];
            }

            $values = join(",", $vals[1]) .'|'.join(",", $vals[0]);
           
            $min_e = min($vals[1]);
            $max_e = max($vals[1]);
            $min_p = min($vals[0]);
            $max_p = max($vals[0]);
            
            $html = $this->renderView('AcmeFmpsBundle:BonCommande:stats.pdf.twig', array('values' => $values, 'min_e' => $min_e, 'max_e' => $max_e, 'min_p' => $min_p, 'max_p' => $max_p, 'stats' => $stats, 'pie_data' => $pie_data, 'panneeBc' => $panneeBc));
            return $this->get('io_tcpdf')->quick_pdf($html);
        }

        return $this->render('AcmeFmpsBundle:BonCommande:stats.html.twig', array('stats' => $stats, 'pie_data' => $pie_data, 'panneeBc' => $panneeBc, 'form' => $form->createView() ));
    }

	
}
