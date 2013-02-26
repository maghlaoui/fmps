<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Abandant;
use Acme\FmpsBundle\Form\AbandantType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Abandant controller.
 *
 * @Route("/abandants")
 */
class AbandantController extends Controller
{
    /**
     * Lists all Abandant entities.
     *
     * @Route("/", name="abandant")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:Abandant')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Abandant entity.
     *
     * @Route("/{id}/show", name="abandant_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Abandant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abandant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Abandant entity.
     *
     * @Route("/new", name="abandant_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Abandant();
        $form   = $this->createForm(new AbandantType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Abandant entity.
     *
     * @Route("/create", name="abandant_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Abandant:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Abandant();
        $request = $this->getRequest();
        $form    = $this->createForm(new AbandantType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abandant_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Abandant entity.
     *
     * @Route("/{id}/edit", name="abandant_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Abandant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abandant entity.');
        }

        $editForm = $this->createForm(new AbandantType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Abandant entity.
     *
     * @Route("/{id}/update", name="abandant_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Abandant:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Abandant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abandant entity.');
        }

        $editForm   = $this->createForm(new AbandantType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abandant_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Abandant entity.
     *
     * @Route("/{id}/delete", name="abandant_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Abandant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Abandant entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Abandant a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('abandant'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
