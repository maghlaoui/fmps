<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Contact;
use Acme\FmpsBundle\Form\ContactType;
use Acme\FmpsBundle\Entity\Partenaire;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Contact controller.
 *
 * @Route("/contacts")
 */
class ContactController extends Controller
{
    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="contact")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $form = $this->getForm();
        $request = $this->getRequest();
        $page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Contact');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,15);
        
        return $this->render('AcmeFmpsBundle:Contact:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}/show", name="contact_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contact();
        $form   = $this->createForm(new ContactType(), $entity);
        
        $request = $this->getRequest();
        $partenaire_id = 0;
        $partenaire_id = (int)$request->query->get('partenaire_id');

        return array(
            'entity' => $entity,
            'partenaire_id' => $partenaire_id,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contact entity.
     *
     * @Route("/create", name="contact_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Contact:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Contact();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContactType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            
            $em->flush();

						if ($request->isXmlHttpRequest()) {
							$data = array('success' => 1, 'dom_id' => 'gestion_partenariat_contact', 'notice' => 'Contact a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getFullName());
							return $this->renderJson($data);
						}
						else {
							$this->get('session')->setFlash('notice', 'Contact a été créé avec succès');
	            return $this->redirect($this->generateUrl('contact_show', array('id' => $entity->getId())));
						}
            
        }

						if ($request->isXmlHttpRequest()) {

							return $this->renderJson( array('success' => 0, 'html' => $html, 'notice' => 'Veuillez vérifier le formulaire') );
						}
						else {
							return array(
    						'entity' => $entity,
    						'form'   => $form->createView(),
  						);
						}

    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}/update", name="contact_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Contact:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm   = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Contact a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('contact_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}/delete", name="contact_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Contact a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('contact'));
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
		  $form = $this->createFormBuilder(new Contact() )
	                ->add('nomContact', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Nom'), 'required' => false))
	                ->add('prenomContact', 'text', array('label' => 'Prénom', 'attr' => array('placeholder' => 'Prénom'), 'required' => false))
	                ->add('mailContact', 'text', array('label' => 'Email', 'attr' => array('placeholder' => 'Email'), 'required' => false))
	                ->add('statusContact', 'text', array('label' => 'Status', 'attr' => array('placeholder' => 'Status'), 'required' => false))
	                ->getForm();
	    return $form;
	  }
	
		private function renderJson($options){
				$response = new Response(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
		}
		
}
