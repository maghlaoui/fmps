<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Versement;
use Acme\FmpsBundle\Form\VersementType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Versement controller.
 *
 * @Route("/versements")
 */
class VersementController extends Controller
{
    /**
     * Lists all Versement entities.
     *
     * @Route("/", name="versement")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
		    $form = $this->createSearchForm();
	    	$page = $this->get('request')->query->get('page', 1);
	
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Versement');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,15);
        
        return $this->render('AcmeFmpsBundle:Versement:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Versement entity.
     *
     * @Route("/{id}/show", name="versement_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Versement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Versement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Versement entity.
     *
     * @Route("/new", name="versement_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Versement();
        $form   = $this->createForm(new VersementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Versement entity.
     *
     * @Route("/create", name="versement_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Versement:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Versement();
        $request = $this->getRequest();
        $form    = $this->createForm(new VersementType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Versement a été créé avec succès');
            return $this->redirect($this->generateUrl('versement_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Versement entity.
     *
     * @Route("/{id}/edit", name="versement_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Versement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Versement entity.');
        }

        $editForm = $this->createForm(new VersementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Versement entity.
     *
     * @Route("/{id}/update", name="versement_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Versement:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Versement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Versement entity.');
        }

        $editForm   = $this->createForm(new VersementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Versement a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('versement_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Versement entity.
     *
     * @Route("/{id}/delete", name="versement_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Versement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Versement entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Versement a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('versement'));
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
			$form = $this->createFormBuilder(new Versement() )
	                ->add('refVirement', 'text', array('label' => 'Référence', 'required' => false, 'attr' => array('placeholder' => 'Référence')))
	                ->add('dateOperation', "date", array('label' => 'Date d\'opération', 'required'  => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'placeholder' => 'Date d\'opération')))
	                ->add('dateValeur', "date", array('label' => 'Date de valeur', 'required'  => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'placeholder' => 'Date de valeur')))
									->add('personnePaiement', 'text', array('label' => 'Effectué par', 'required' => false, 'attr' => array('placeholder' => 'Effectué par')))
									->getForm();
	        return $form;
		}
}
