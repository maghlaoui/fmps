<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EnfantClasse;
use Acme\FmpsBundle\Form\EnfantClasseType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EnfantClasse controller.
 *
 * @Route("/enfants_classes")
 */
class EnfantClasseController extends Controller
{
    /**
     * Lists all EnfantClasse entities.
     *
     * @Route("/", name="enfantclasse")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$paginator = $this->get('knp_paginator');
				$current_page = $this->get('request')->query->get('page', 1);
				$dql = "SELECT ec FROM AcmeFmpsBundle:EnfantClasse ec";
        $query = $em->createQuery($dql);
        $entities = $paginator->paginate($query, $current_page,15);

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a EnfantClasse entity.
     *
     * @Route("/{id}/show", name="enfantclasse_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantClasse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EnfantClasse entity.
     *
     * @Route("/new", name="enfantclasse_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EnfantClasse();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EnfantClasseType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EnfantClasse entity.
     *
     * @Route("/create", name="enfantclasse_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EnfantClasse:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EnfantClasse();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EnfantClasseType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('enfantclasse_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EnfantClasse entity.
     *
     * @Route("/{id}/edit", name="enfantclasse_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantClasse entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EnfantClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EnfantClasse entity.
     *
     * @Route("/{id}/update", name="enfantclasse_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EnfantClasse:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantClasse entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EnfantClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('enfantclasse_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EnfantClasse entity.
     *
     * @Route("/{id}/delete", name="enfantclasse_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EnfantClasse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EnfantClasse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('enfantclasse'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
