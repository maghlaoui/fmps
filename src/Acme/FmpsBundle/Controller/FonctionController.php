<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Fonction;
use Acme\FmpsBundle\Form\FonctionType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Fonction controller.
 *
 * @Route("/fonctions")
 */
class FonctionController extends Controller
{
    /**
     * Lists all Fonction entities.
     *
     * @Route("/", name="fonction")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

				$sort = $this->getRequest()->request->get('sort');
				$order = empty($sort) ? 'ORDER BY f.niveauHierarchique' : '';

        $dql = "SELECT f FROM AcmeFmpsBundle:Fonction f " . $order;
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:Fonction:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a Fonction entity.
     *
     * @Route("/{id}/show", name="fonction_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Fonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fonction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Fonction entity.
     *
     * @Route("/new", name="fonction_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fonction();
        $form   = $this->createForm(new FonctionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Fonction entity.
     *
     * @Route("/create", name="fonction_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Fonction:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Fonction();
        $request = $this->getRequest();
        $form    = $this->createForm(new FonctionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$dom_id = $request->get('dom_id');

						if ($request->isXmlHttpRequest()) {
							$data = array('success' => 1, 'dom_id' => $dom_id, 'notice' => 'Fonction a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getLibele());
							return $this->renderJson($data);
						}
						else {
              $this->get('session')->setFlash('notice', 'Fonction a été créée avec succès');
              return $this->redirect($this->generateUrl('fonction_show', array('id' => $entity->getId())));
            }
        }

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

    /**
     * Displays a form to edit an existing Fonction entity.
     *
     * @Route("/{id}/edit", name="fonction_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Fonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fonction entity.');
        }

        $editForm = $this->createForm(new FonctionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fonction entity.
     *
     * @Route("/{id}/update", name="fonction_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Fonction:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Fonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fonction entity.');
        }

        $editForm   = $this->createForm(new FonctionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Fonction a été mise à jour avec succès');

            return $this->redirect($this->generateUrl('fonction_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fonction entity.
     *
     * @Route("/{id}/delete", name="fonction_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Fonction')->find($id);
            if ( count($entity->getEmployes()) > 0)
						{
							 $this->get('session')->setFlash('error', 'Vous ne pouvez pas supprimer cette fonction');
							 return $this->redirect($this->generateUrl('fonction_show', array('id' => $id)));
						}
						

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fonction entity.');
            }

						if ( count($entity->getFonctions()) > 0 ){
							$this->get('session')->setFlash('error', 'Impossible de supprimer cette fonction');
							
							return $this->redirect($this->generateUrl('fonction'));
						}

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Fonction a été supprimée avec succès');
        }
        
        return $this->redirect($this->generateUrl('fonction'));
        
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

	private function getForm()
	{
		
	}
}
