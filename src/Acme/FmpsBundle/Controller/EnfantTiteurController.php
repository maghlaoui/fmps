<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EnfantTiteur;
use Acme\FmpsBundle\Form\EnfantTiteurType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EnfantTiteur controller.
 *
 * @Route("/enfants_titeurs")
 */
class EnfantTiteurController extends Controller
{
    /**
     * Lists all EnfantTiteur entities.
     *
     * @Route("/", name="enfanttiteur")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:EnfantTiteur')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a EnfantTiteur entity.
     *
     * @Route("/{id}/show", name="enfanttiteur_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantTiteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantTiteur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EnfantTiteur entity.
     *
     * @Route("/new", name="enfanttiteur_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EnfantTiteur();
        $form   = $this->createForm(new EnfantTiteurType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EnfantTiteur entity.
     *
     * @Route("/create", name="enfanttiteur_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EnfantTiteur:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EnfantTiteur();
        $request = $this->getRequest();
        $form    = $this->createForm(new EnfantTiteurType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
			$this->get('session')->setFlash('notice', 'Enfant titeur a été ajouté avec succès');

            return $this->redirect($this->generateUrl('enfanttiteur_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EnfantTiteur entity.
     *
     * @Route("/{id}/edit", name="enfanttiteur_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantTiteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantTiteur entity.');
        }

        $editForm = $this->createForm(new EnfantTiteurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EnfantTiteur entity.
     *
     * @Route("/{id}/update", name="enfanttiteur_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EnfantTiteur:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EnfantTiteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnfantTiteur entity.');
        }

        $editForm   = $this->createForm(new EnfantTiteurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
			$this->get('session')->setFlash('notice', 'Enfant titeur a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('enfanttiteur_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EnfantTiteur entity.
     *
     * @Route("/{id}/delete", name="enfanttiteur_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EnfantTiteur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EnfantTiteur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('enfanttiteur'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
