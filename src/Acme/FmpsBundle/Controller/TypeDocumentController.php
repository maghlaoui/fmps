<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\TypeDocument;
use Acme\FmpsBundle\Form\TypeDocumentType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * TypeDocument controller.
 *
 * @Route("/types_document")
 */
class TypeDocumentController extends Controller
{
    /**
     * Lists all TypeDocument entities.
     *
     * @Route("/", name="typedocument")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT t FROM AcmeFmpsBundle:TypeDocument t";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:TypeDocument:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a TypeDocument entity.
     *
     * @Route("/{id}/show", name="typedocument_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDocument entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TypeDocument entity.
     *
     * @Route("/new", name="typedocument_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TypeDocument();
        $form   = $this->createForm(new TypeDocumentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TypeDocument entity.
     *
     * @Route("/create", name="typedocument_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeDocument:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TypeDocument();
        $request = $this->getRequest();
        $form    = $this->createForm(new TypeDocumentType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$dom_id = $request->get('dom_id');

						if ($request->isXmlHttpRequest()) {
							$data = array('success' => 1, 'dom_id' => $dom_id, 'notice' => 'Type de document a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getLibelleTypedocument());
							return $this->renderJson($data);
						}
						else {
              $this->get('session')->setFlash('notice', 'Type de document a été créé avec succès');
	            return $this->redirect($this->generateUrl('typedocument_show', array('id' => $entity->getId())));
            }
               
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing TypeDocument entity.
     *
     * @Route("/{id}/edit", name="typedocument_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDocument entity.');
        }

        $editForm = $this->createForm(new TypeDocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TypeDocument entity.
     *
     * @Route("/{id}/update", name="typedocument_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeDocument:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDocument entity.');
        }

        $editForm   = $this->createForm(new TypeDocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Type de document a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('typedocument_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TypeDocument entity.
     *
     * @Route("/{id}/delete", name="typedocument_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:TypeDocument')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeDocument entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Type de document a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('typedocument'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

		protected function _getErrors($form)
		{
		    // Validate form
		    $errors = $this->get('validator')->validate($form);

		    // Prepare collection
		    $collection = array();

		    // Loop through each element of the form
		    foreach ($form->getChildren() as $key => $child) {
		        $collection[$key] = "";
		    }
				$translator = $this->get('translator');
		    foreach ($errors as $error) {
		        $collection[str_replace("data.", "", $error->getPropertyPath())] = $translator->trans($error->getMessage());
		    }
		    return $collection;
		}
		
		public function renderJson($options)
	  {
			$response = new Response(json_encode($options));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
		}
}
