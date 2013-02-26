<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\MoisGratuit;
use Acme\FmpsBundle\Form\MoisGratuitType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * MoisGratuit controller.
 *
 * @Route("/moisgratuit")
 */
class MoisGratuitController extends Controller
{
    /**
     * Lists all MoisGratuit entities.
     *
     * @Route("/", name="moisgratuit")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:MoisGratuit')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a MoisGratuit entity.
     *
     * @Route("/{id}/show", name="moisgratuit_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:MoisGratuit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoisGratuit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new MoisGratuit entity.
     *
     * @Route("/new", name="moisgratuit_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MoisGratuit();
        $form   = $this->createForm(new MoisGratuitType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new MoisGratuit entity.
     *
     * @Route("/create", name="moisgratuit_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:MoisGratuit:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new MoisGratuit();
        $request = $this->getRequest();
        $form    = $this->createForm(new MoisGratuitType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moisgratuit_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing MoisGratuit entity.
     *
     * @Route("/{id}/edit", name="moisgratuit_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:MoisGratuit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoisGratuit entity.');
        }

        $editForm = $this->createForm(new MoisGratuitType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MoisGratuit entity.
     *
     * @Route("/{id}/update", name="moisgratuit_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:MoisGratuit:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:MoisGratuit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoisGratuit entity.');
        }

        $editForm   = $this->createForm(new MoisGratuitType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moisgratuit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MoisGratuit entity.
     *
     * @Route("/{id}/delete", name="moisgratuit_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:MoisGratuit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MoisGratuit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moisgratuit'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
