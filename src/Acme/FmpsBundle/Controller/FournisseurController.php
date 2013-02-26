<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Fournisseur;
use Acme\FmpsBundle\Form\FournisseurType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Fournisseur controller.
 *
 * @Route("/fournisseurs")
 */
class FournisseurController extends Controller
{
    /**
     * Lists all Fournisseur entities.
     *
     * @Route("/", name="fournisseur")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT f FROM AcmeFmpsBundle:Fournisseur f";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $form = $this->getForm();
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Fournisseur');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:Fournisseur:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Fournisseur entity.
     *
     * @Route("/{id}/show", name="fournisseur_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $entity = $em->getRepository('AcmeFmpsBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Fournisseur entity.
     *
     * @Route("/new", name="fournisseur_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fournisseur();
        $form   = $this->createForm(new FournisseurType(), $entity);
        
        $request = $this->getRequest();
        $back_url = $request->query->get('back_url');
        $this->get('session')->set('back_url', $back_url);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Fournisseur entity.
     *
     * @Route("/create", name="fournisseur_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Fournisseur:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Fournisseur();
        $request = $this->getRequest();
        $form    = $this->createForm(new FournisseurType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Fournisseur a été créé avec succès');
						
            if ( $this->get('session')->get('back_url') ) {
							$this->get('session')->set('back_url', null);
							return $this->redirect($this->generateUrl('boncommande_new'));
						}
						else{
							 return $this->redirect($this->generateUrl('fournisseur_show', array('id' => $entity->getId())));
						}
           
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Fournisseur entity.
     *
     * @Route("/{id}/edit", name="fournisseur_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }
        
        $request = $this->getRequest();
        $bon_commande_id = $request->query->get('bon_commande_id');
        $this->get('session')->set('bon_commande_id', $bon_commande_id);

        $editForm = $this->createForm(new FournisseurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fournisseur entity.
     *
     * @Route("/{id}/update", name="fournisseur_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Fournisseur:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Fournisseur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fournisseur entity.');
        }

        $editForm   = $this->createForm(new FournisseurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Fournisseur a été mis à jour avec succès');
            
            if ($this->get('session')->get('bon_commande_id')){
               $bon_commande_id = $this->get('session')->get('bon_commande_id');
               $this->get('session')->set('bon_commande_id', null);
               return $this->redirect($this->generateUrl('boncommande_show', array('id' => $bon_commande_id ))); 
            }
            else {
               return $this->redirect($this->generateUrl('fournisseur_show', array('id' => $id)));
            }

            
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fournisseur entity.
     *
     * @Route("/{id}/delete", name="fournisseur_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Fournisseur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fournisseur entity.');
            }
            
         $em->remove($entity);
         $em->flush();

				 $this->get('session')->setFlash('notice', 'Fournisseur a été supprimé avec succès');
         }

         return $this->redirect($this->generateUrl('fournisseur'));
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
		$form = $this->createFormBuilder(new Fournisseur() )
                ->add('nom', 'text', array('required' => false, 'attr' => array('placeholder' => 'Nom', 'class' => 'span2')))
                ->add('adresse', 'text', array('required' => false, 'attr' => array('placeholder' => 'Adresse', 'class' => 'span2')))
                ->add('telephone', 'text', array('label' => 'Téléphone', 'required' => false, 'attr' => array('placeholder' => 'Téléphone', 'class' => 'span2')))
                ->add('registreCommerce', 'text', array('label' => 'Registre de commerce','required' => false, 'attr' => array('placeholder' => 'Registre de commerce', 'class' => 'span2')))
                ->add('numeroPatente', 'text', array('label' => 'Numéro de patente', 'required' => false, 'attr' => array('placeholder' => 'Numéro de patente', 'class' => 'span2')))
                ->add('identifiantFiscale', 'text', array('label' => 'Identifiant fiscale', 'required' => false, 'attr' => array('placeholder' => 'Identifiant fiscale', 'class' => 'span2')))
                ->add('numeroRib', 'text', array('label' => 'Numéro du RIB', 'required' => false, 'attr' => array('placeholder' => 'Numéro de RIB', 'class' => 'span2')))
                ->add('banque', 'text', array('required' => false, 'attr' => array('placeholder' => 'Banque', 'class' => 'span2')))
                ->add('attestationRib', 'file', array('label' => 'Attestation de RIB', 'required' => false, 'attr' => array('placeholder' => 'Attestation de RIB', 'class' => 'span2')))
                ->getForm();
		return $form;
	}
}
