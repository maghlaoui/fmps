<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Category;
use Acme\FmpsBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Category controller.
 *
 * @Route("/categories")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT c FROM AcmeFmpsBundle:Category c";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:Category:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="category_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="category_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Category:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Category();
        $request = $this->getRequest();
        $form    = $this->createForm(new CategoryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
           $em = $this->getDoctrine()->getEntityManager();
           $em->persist($entity);
           $em->flush();

		       $this->get('session')->setFlash('notice', 'Catégorie a été créée avec succès');
		
					 return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
        }

				else {
					
						return array(
	            'entity' => $entity,
	            'form'   => $form->createView()
	          );
				}

    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="category_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Category:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm   = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Catégorie a été mise à jour avec succès');

            return $this->redirect($this->generateUrl('category_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="category_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

						if ( count($entity->getOffresServices()) > 0 ){
							$this->get('session')->setFlash('error', 'Impossible de supprimer cette catégorie');
							return $this->redirect($this->generateUrl('category'));
						}

					  $em->remove($entity);
	          $em->flush();
	
					  $this->get('session')->setFlash('notice', 'Catégorie a été supprimée avec succès');
        }
        
        return $this->redirect($this->generateUrl('category'));    
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
