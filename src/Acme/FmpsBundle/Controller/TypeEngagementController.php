<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\TypeEngagement;
use Acme\FmpsBundle\Form\TypeEngagementType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * TypeEngagement controller.
 *
 * @Route("/types_engagement")
 */
class TypeEngagementController extends Controller
{
    /**
     * Lists all TypeEngagement entities.
     *
     * @Route("/", name="typeengagement")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT t FROM AcmeFmpsBundle:TypeEngagement t";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:TypeEngagement:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a TypeEngagement entity.
     *
     * @Route("/{id}/show", name="typeengagement_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEngagement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TypeEngagement entity.
     *
     * @Route("/new", name="typeengagement_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TypeEngagement();
        $form   = $this->createForm(new TypeEngagementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TypeEngagement entity.
     *
     * @Route("/create", name="typeengagement_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeEngagement:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TypeEngagement();
        $request = $this->getRequest();
        $form    = $this->createForm(new TypeEngagementType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						if ($request->isXmlHttpRequest()) {
							$data = array('success' => 1, 'dom_id' => 'partenariat_partenaire_type_engagement', 'notice' => 'Type d\'engagement a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getLibelleTypeEngagement());
							return $this->renderJson($data);
						}
						else {
							$this->get('session')->setFlash('notice', 'Périodicité a été créé avec succès');
							return $this->redirect($this->generateUrl('typeengagement_show', $entity->getId()));
						}
            
        }

				else {
					
					if ($request->isXmlHttpRequest()) {
						return $this->renderJson( array('success' => 0, 'notice' => 'Veuillez vérifier le formulaire') );
					}
					else {
						return array(
	            'entity' => $entity,
	            'form'   => $form->createView(),
							'errors' => $this->_getErrors($form)
	          );
					}
				}

    }

    /**
     * Displays a form to edit an existing TypeEngagement entity.
     *
     * @Route("/{id}/edit", name="typeengagement_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEngagement entity.');
        }

        $editForm = $this->createForm(new TypeEngagementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TypeEngagement entity.
     *
     * @Route("/{id}/update", name="typeengagement_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeEngagement:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeEngagement entity.');
        }

        $editForm   = $this->createForm(new TypeEngagementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Type d engagement a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('typeengagement_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TypeEngagement entity.
     *
     * @Route("/{id}/delete", name="typeengagement_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeEngagement entity.');
            }

						$em->remove($entity);
	          $em->flush();
	
						$this->get('session')->setFlash('notice', 'Type d\'engagement a été supprimé avec succès');
				}
					 
        return $this->redirect($this->generateUrl('typeengagement'));
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
		
		public function renderJson($options){
				$response = new Response(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
		}
}
