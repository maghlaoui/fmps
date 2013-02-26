<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Document;
use Acme\FmpsBundle\Entity\TypeDocument;
use Acme\FmpsBundle\Form\DocumentType;
use Acme\FmpsBundle\Form\TypeDocumentType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Document controller.
 *
 * @Route("/documents")
 */
class DocumentController extends Controller
{
    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
				$form = $this->getForm();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Document');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:Document:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}/show", name="document_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Document();
        $request = $this->getRequest();
        $partenariatId = $this->getRequest()->query->get('partenariat_id');

				if ( !empty($partenariatId) ){
					$em = $this->getDoctrine()->getEntityManager();
					$partenariat = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($partenariatId);
					$entity->setPartenariat($partenariat);
				}
        $form   = $this->createForm(new DocumentType(), $entity);

				$type_document = new TypeDocument();
        $type_document_form   = $this->createForm(new TypeDocumentType(), $type_document);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'type_document_form'   => $type_document_form->createView()
        );
    }

    /**
     * Creates a new Document entity.
     *
     * @Route("/create", name="document_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Document:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Document();
        $request = $this->getRequest();
        $form    = $this->createForm(new DocumentType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Document a été créé avec succès');
            
            $partenariatId = $entity->getPartenariat()->getId();
            return $this->redirect($this->generateUrl('partenariat_show', array('id' => $partenariatId ))); 
           
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createForm(new DocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Document entity.
     *
     * @Route("/{id}/update", name="document_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Document:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm   = $this->createForm(new DocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Document a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('document_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}/delete", name="document_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Document a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('document')); 
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
		$form = $this->createFormBuilder(new Document() )
                ->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->add('type_document', 'entity', array('class' => 'AcmeFmpsBundle:TypeDocument', 'label' => 'Type du document', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->getForm();
        return $form;
	}
}
