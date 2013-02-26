<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\BonLivraison;
use Acme\FmpsBundle\Form\BonLivraisonType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * BonLivraison controller.
 *
 * @Route("/bons_livraison")
 */
class BonLivraisonController extends Controller
{
    /**
     * Lists all BonLivraison entities.
     *
     * @Route("/", name="bonlivraison")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $form = $this->getForm();
        $request = $this->getRequest();
        $form->bindRequest($request);
				$page = $this->get('request')->query->get('page', 1);
        $repository = $em->getRepository('AcmeFmpsBundle:BonLivraison');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page, 15);
        
        return $this->render('AcmeFmpsBundle:BonLivraison:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a BonLivraison entity.
     *
     * @Route("/{id}/show", name="bonlivraison_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:BonLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonLivraison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new BonLivraison entity.
     *
     * @Route("/new", name="bonlivraison_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BonLivraison();
        $request = $this->getRequest();
        $bon_commande_id = $request->query->get('bon_commande_id');
        $this->get('session')->set('bon_commande_id', $bon_commande_id);
        $entity->setBonCommandeId($bon_commande_id);
        $form   = $this->createForm(new BonLivraisonType(), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new BonLivraison entity.
     *
     * @Route("/create", name="bonlivraison_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:BonLivraison:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new BonLivraison();
        $request = $this->getRequest();
        $form    = $this->createForm(new BonLivraisonType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $postData = $request->request->get('bon_livraison');
            $bonCommandeId = $postData['bonCommande'];
            
            $this->get('session')->setFlash('notice', 'Bon de livraison a été créé avec succès');
            
            $retour = $request->get('retour');
            if($retour == 1){
              return $this->redirect($this->generateUrl('bonlivraison_new', array('bon_commande_id' => $bonCommandeId)));
            }
            else if($retour == 2){
              return $this->redirect($this->generateUrl('bonlivraison'));
            }
            else{
              $this->get('session')->set('bon_commande_id', null);
              return $this->redirect($this->generateUrl('boncommande_show', array('id' => $bonCommandeId)));
            }
  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing BonLivraison entity.
     *
     * @Route("/{id}/edit", name="bonlivraison_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:BonLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonLivraison entity.');
        }

        $editForm = $this->createForm(new BonLivraisonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BonLivraison entity.
     *
     * @Route("/{id}/update", name="bonlivraison_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:BonLivraison:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:BonLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonLivraison entity.');
        }

        $editForm   = $this->createForm(new BonLivraisonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Bon de livraison a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('bonlivraison_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BonLivraison entity.
     *
     * @Route("/{id}/delete", name="bonlivraison_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:BonLivraison')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BonLivraison entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Bon de livraison a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('BonLivraison')); 
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

	private function getForm()
	{
		$form = $this->createFormBuilder(new BonLivraison() )
                ->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'empty_value' => '--Sélectionnez--', 'required' => false))
                ->getForm();
		return $form;
	}
}
