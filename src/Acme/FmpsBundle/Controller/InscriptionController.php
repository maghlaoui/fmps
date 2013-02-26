<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Inscription;
use Acme\FmpsBundle\Form\InscriptionType;
use Doctrine\ORM\EntityRepository;
use Acme\FmpsBundle\Entity\Enfant;
use Acme\FmpsBundle\Form\EnfantType;
use Acme\FmpsBundle\Entity\Titeur;
use Acme\FmpsBundle\Form\TiteurType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Inscription controller.
 *
 * @Route("/inscriptions")
 */
class InscriptionController extends Controller
{
    /**
     * Lists all Inscription entities.
     *
     * @Route("/", name="inscription")
     * @Template()
     */
    public function indexAction()
    {
	
			 $em = $this->getDoctrine()->getEntityManager();
       $paginator = $this->get('knp_paginator');
       $request = $this->getRequest();
		   $form = $this->createSearchForm();
		   $page = $request->query->get('page', 1);

       $form->bindRequest($request);
       $repository = $em->getRepository('AcmeFmpsBundle:Inscription');
       $user = $this->get('security.context')->getToken()->getUser();
       $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page,15);
        
       return $this->render('AcmeFmpsBundle:Inscription:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Inscription entity.
     *
     * @Route("/{id}/show", name="inscription_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Inscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Inscription entity.
     *
     * @Route("/new", name="inscription_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Inscription();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new InscriptionType(), $entity, array('user' => $user));
				$ville = $user->getEmploye()->getEcole()->getVille()->getId();
        $enfant = new Enfant();
        $enfant_form = $this->createForm(new EnfantType(), $enfant);

        $titeur = new Titeur();
        $titeur_form = $this->createForm(new TiteurType(), $titeur, array('user' => $user));
        
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'enfant_form' => $enfant_form->createView(),
            'titeur_form' => $titeur_form->createView(),
        );
    }

		  /**
	     * Creates a new Inscription entity.
	     *
	     * @Route("/create", name="inscription_create")
	     * @Method("post")
	     * @Template("AcmeFmpsBundle:Inscription:new.html.twig")
	     */
	    public function createAction() {
	        $entityInscription = new Inscription();
	        $request = $this->getRequest();
	        $user = $this->get('security.context')->getToken()->getUser();
	        $inscription_form = $this->createForm(new InscriptionType(), $entityInscription, array('user' => $user));

	        $entityEnfant = new \Acme\FmpsBundle\Entity\Enfant;
	        $enfant_form = $this->createForm(new EnfantType(), $entityEnfant);

	        $entityTiteur = new \Acme\FmpsBundle\Entity\Titeur;
	        $titeur_form = $this->createForm(new TiteurType(), $entityTiteur, array('user' => $user));



	        $inscription_form->bindRequest($request);
	        $enfant_form->bindRequest($request);
	        $titeur_form->bindRequest($request);

	        // var_dump(array($inscription_form,$enfant_form,$titeur_form,$paiement_form));die;
	        if ($enfant_form->isValid() && $inscription_form->isValid()) {
	            $em = $this->getDoctrine()->getEntityManager();
              if($entityInscription->getTiteur()){

              }else  if(!$entityInscription->getTiteur()){
                if($titeur_form->isValid()){
                  $entityInscription->setTiteur($entityTiteur);
								  $entityTiteur->setEcole($entityInscription->getEcole());
	                $em->persist($entityTiteur);
	                $em->flush();
                }
						  }

							$entityEnfant->setEcole($entityInscription->getEcole());
	            $em->persist($entityEnfant);
	            $em->flush();

	            $entityInscription->setEnfant($entityEnfant);
	        
	            $em->persist($entityInscription);

	            $em->flush();
	              return $this->redirect($this->generateUrl('paiement_new', array('inscription_id' => $entityInscription->getId())));
	        }





	        return array(
	            'entity' => $entityInscription,
	            'form' => $inscription_form->createView(),
	            'enfant_form' => $enfant_form->createView(),
	            'titeur_form' => $titeur_form->createView(),
	        );
	    }
    /**
     * Displays a form to edit an existing Inscription entity.
     *
     * @Route("/{id}/edit", name="inscription_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Inscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscription entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new InscriptionType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

				$enfant = new Enfant();
        $enfant_form   = $this->createForm(new EnfantType(), $enfant);

				$titeur = new Titeur();
        $titeur_form   = $this->createForm(new TiteurType(), $titeur);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Inscription entity.
     *
     * @Route("/{id}/update", name="inscription_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Inscription:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Inscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscription entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new InscriptionType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Inscription a été mise à jour avec succès');
            return $this->redirect($this->generateUrl('inscription_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
						'enfant_form'   => $enfant_form->createView(),
						'titeur_form'   => $titeur_form->createView(),
        );
    }

    /**
     * Deletes a Inscription entity.
     *
     * @Route("/{id}/delete", name="inscription_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Inscription')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Inscription entity.');
            }
						
            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Inscription à une offre de service a été supprimée avec succès');
        }

        return $this->redirect($this->generateUrl('inscription'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

   	private function createSearchForm()
		{
			$user = $this->get('security.context')->getToken()->getUser();
			$ecoles = $user->getEcoles();
		  if ( !empty($ecoles) && !in_array(1, $ecoles) )
		  {
		     $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
		  }
		  else{
		     $where = 'e.id > 1';
		  }
			$form = $this->createFormBuilder(new Inscription() )
	                ->add('numDemande', 'text', array('label' => 'Numéro', 'required' => false, 'attr' => array('placeholder' => 'Nom', 'class' => 'small')))
	                ->add('typeDemande', 'text', array('label' => 'Type de demande', 'required' => false, 'attr' => array('placeholder' => 'Adresse'))) 
	                ->add('dateDemande', 'date', array('label' => 'Date de demande', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date small', 'placeholder' => "Date d'ouverture")))
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
	                ->add('anneeScolaire', 'entity', array('required' => false, 'class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--', 
								              'query_builder' => function (EntityRepository $er) 
								                   {
								                       return $er->createQueryBuilder('a')
								                              ->orderBy('a.libelleAnneeScolaire', 'DESC');
								                   }
								                   ))
	->add('titeur', 'entity', array('class' => 'AcmeFmpsBundle:Titeur', 'label' => 'Titeur', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	->add('enfant', 'entity', array('class' => 'AcmeFmpsBundle:Enfant', 'label' => 'Enfant', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->getForm();
	        return $form;
		}
		
		/**
     * Lists all Inscription entities.
     *
     * @Route("/stats", name="inscription_stats")
     * @Template()
     */
    public function statsAction()
    {
       $em = $this->getDoctrine()->getEntityManager();
       $paginator = $this->get('knp_paginator');
       $request = $this->getRequest();

       $user = $this->get('security.context')->getToken()->getUser();

       $dql = "SELECT i.id ,i,s.libelleSection, e.nom,a.libelleAnneeScolaire,count(i) as nombre FROM AcmeFmpsBundle:Inscription i , AcmeFmpsBundle:Ecole e ,
      AcmeFmpsBundle:AnneeScolaire a,AcmeFmpsBundle:Affectation af,AcmeFmpsBundle:Section s where i.ecole=e.id and i.anneeScolaire=a.id
      and af.ecole=i.ecole and  af.employe =" . $user->getEmploye()->getId() . " and s.id=i.section
      group by i.ecole,i.anneeScolaire,i.section ORDER BY a.id,s.id ";
       $query = $em->createQuery($dql);
       $result = $query->getResult();

       $paginator = $this->get('knp_paginator');


       $entities = $paginator->paginate($result, $request->query->get('page', 1), 15);

       return $this->render('AcmeFmpsBundle:Inscription:stats.html.twig', array('entities' => $entities));
    }

}
