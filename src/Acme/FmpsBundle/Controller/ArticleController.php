<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Article;
use Acme\FmpsBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Article controller.
 *
 * @Route("/articles")
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        $form->bindRequest($request);
        $page = $this->get('request')->query->get('page', 1);
        $repository = $em->getRepository('AcmeFmpsBundle:Article');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page, 15);
        
        
        return $this->render('AcmeFmpsBundle:Article:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}/show", name="article_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Article();
        $form   = $this->createForm(new ArticleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="article_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Article:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Article();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArticleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Article a été créé avec succès');

            return $this->redirect($this->generateUrl('article_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}/update", name="article_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Article:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm   = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Article a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('article_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}/delete", name="article_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Article')->findOneById($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }
            
            if ($entity->getArticlesBonsCommande()->count() > 0){
                $this->get('session')->setFlash('error', 'Cet article est utilisé dans les bon de comande vous ne pouvez pas le supprimer');
            }
            else{   
                $em->remove($entity);
                $em->flush();

								$this->get('session')->setFlash('notice', 'Article a été supprimé avec succès');
            }
        }

        return $this->redirect($this->generateUrl('article'));
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
		$form = $this->createFormBuilder(new Article() )
                ->add('designation', 'text', array('label' => 'Désignation', 'required' => false, 'attr' => array('placeholder' => 'Désignation')))
                ->add('description', 'text', array('required' => false, 'attr' => array('placeholder' => 'Description')))
                ->getForm();
		return $form;
	}
}
