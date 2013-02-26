<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Facture;
use Acme\FmpsBundle\Form\FactureType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Facture controller.
 *
 * @Route("/factures")
 */
class FactureController extends Controller
{
    /**
     * Lists all Facture entities.
     *
     * @Route("/", name="facture")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');

        $form = $this->getForm();
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Facture');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1), 15);
        
        return $this->render('AcmeFmpsBundle:Facture:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/{id}/show", name="facture_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Facture entity.
     *
     * @Route("/new", name="facture_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Facture();
        $request = $this->getRequest();
        $bon_commande_id = $request->query->get('bon_commande_id');
        $this->get('session')->set('bon_commande_id', $bon_commande_id);
        $entity->setBonCommandeId($bon_commande_id);
        $form   = $this->createForm(new FactureType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Facture entity.
     *
     * @Route("/create", name="facture_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Facture:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Facture();
        $request = $this->getRequest();
        $form    = $this->createForm(new FactureType(), $entity);
        $form->bindRequest($request);
     
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $postData = $request->request->get('facture');
            $bonCommandeId = $postData['bonCommande'];
            $this->get('session')->setFlash('notice', 'Facture a été créé avec succès');
            
            $retour = $request->get('retour');
            if($retour == 1){
              return $this->redirect($this->generateUrl('facture_new', array('bon_commande_id' => $bonCommandeId)));
            }
            else if($retour == 2){
              return $this->redirect($this->generateUrl('facture'));
            }
            else{
              $this->get('session')->set('bon_commande_id', null);
              return $this->redirect($this->generateUrl('boncommande_show', array('id' => $bonCommandeId)));
            }

            return $this->redirect($this->generateUrl('facture_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Facture entity.
     *
     * @Route("/{id}/edit", name="facture_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm = $this->createForm(new FactureType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Facture entity.
     *
     * @Route("/{id}/update", name="facture_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Facture:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm   = $this->createForm(new FactureType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
   
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Facture a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('facture_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Delete a Facture entity.
     *
     * @Route("/{id}/delete", name="facture_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid() || $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Facture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Facture entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Facture a été supprimé avec succès');
        }

 				return $this->redirect($this->generateUrl('facture'));
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
		$form = $this->createFormBuilder(new Facture() )
                ->add('numero', 'text', array('label' => 'Numéro', 'required' => false, 'attr' => array('placeholder' => 'Numéro', 'class' => 'span1' )))
                ->add('datePrevisionPaiement', 'date', array('label' => 'Date de prévision', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date span2', 'placeholder' => 'Date de prévision')))
                ->add('datePaiement', 'date', array('label' => 'Date de paiement', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date span2', 'placeholder' => 'Date de paiement')))
                ->add('etat', 'choice',  array('choices' => Facture::getDefaultStatus(), 'required' => false, 'empty_value' => '--Sélectionnez--', 'attr' => array('class' => 'span2')))
                ->add('typePaiement', 'choice',  array('choices' => Facture::getDefaultPaymentTypes(), 'label' => 'Type de paiement', 'empty_value' => '--Sélectionnez--', 'required' => false, 'attr' => array('class' => 'span2')))
                ->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'empty_value' => '--Sélectionnez--', 'required' => false, 'attr' => array('class' => 'span2')))
                ->getForm();
	   return $form;
	}
}
