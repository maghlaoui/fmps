<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\ActualiteRubrique;
use Acme\FmpsBundle\Form\ActualiteRubriqueType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ActualiteRubrique controller.
 *
 * @Route("/actualite_rubriques")
 */
class ActualiteRubriqueController extends Controller
{
    /**
     * Lists all ActualiteRubrique entities.
     *
     * @Route("/", name="actualiterubrique")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        if (count($request->query->all()) > 0) 
        {//on teste si des valeurs sont transmises par get
            $form->bindRequest($request);
            $repository = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique');
            $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1), 1);
        } 
        else 
        {
            $entitiess = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique')->findAll();
            $entities = $paginator->paginate($entitiess, $request->query->get('page', 1), 1);
        }
        return $this->render('AcmeFmpsBundle:ActualiteRubrique:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
    }

    /**
     * Finds and displays a ActualiteRubrique entity.
     *
     * @Route("/{id}/show", name="actualiterubrique_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActualiteRubrique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ActualiteRubrique entity.
     *
     * @Route("/new", name="actualiterubrique_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ActualiteRubrique();
        $form   = $this->createForm(new ActualiteRubriqueType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ActualiteRubrique entity.
     *
     * @Route("/create", name="actualiterubrique_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ActualiteRubrique:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ActualiteRubrique();
        $request = $this->getRequest();
        $form    = $this->createForm(new ActualiteRubriqueType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actualiterubrique_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ActualiteRubrique entity.
     *
     * @Route("/{id}/edit", name="actualiterubrique_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActualiteRubrique entity.');
        }

        $editForm = $this->createForm(new ActualiteRubriqueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ActualiteRubrique entity.
     *
     * @Route("/{id}/update", name="actualiterubrique_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ActualiteRubrique:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActualiteRubrique entity.');
        }

        $editForm   = $this->createForm(new ActualiteRubriqueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actualiterubrique_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ActualiteRubrique entity.
     *
     * @Route("/{id}/delete", name="actualiterubrique_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:ActualiteRubrique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ActualiteRubrique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('actualiterubrique'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
       private function getForm() {
        $form = $this->createFormBuilder(new ActualiteRubrique())
                
                ->add('title', 'text', array('required' => false, 'attr' => array('placeholder' => 'Titre')))
                ->add('published', 'choice', array('choices'   => array('false' => 'Non', '1' => 'Oui'),'empty_value' => '--Sélectionnez--','required' => false, 'attr' => array('placeholder' => 'Publié')))
                ->getForm();
        return $form;
    }
}
