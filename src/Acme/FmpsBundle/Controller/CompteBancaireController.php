<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\CompteBancaire;
use Acme\FmpsBundle\Form\CompteBancaireType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * CompteBancaire controller.
 *
 * @Route("/comptes_bancaire")
 */
class CompteBancaireController extends Controller
{
    /**
     * Lists all CompteBancaire entities.
     *
     * @Route("/", name="comptebancaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:CompteBancaire')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a CompteBancaire entity.
     *
     * @Route("/{id}/show", name="comptebancaire_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:CompteBancaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompteBancaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new CompteBancaire entity.
     *
     * @Route("/new", name="comptebancaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CompteBancaire();
        $form   = $this->createForm(new CompteBancaireType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new CompteBancaire entity.
     *
     * @Route("/create", name="comptebancaire_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:CompteBancaire:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new CompteBancaire();
        $request = $this->getRequest();
        $form    = $this->createForm(new CompteBancaireType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comptebancaire_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing CompteBancaire entity.
     *
     * @Route("/{id}/edit", name="comptebancaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:CompteBancaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompteBancaire entity.');
        }

        $editForm = $this->createForm(new CompteBancaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CompteBancaire entity.
     *
     * @Route("/{id}/update", name="comptebancaire_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:CompteBancaire:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:CompteBancaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompteBancaire entity.');
        }

        $editForm   = $this->createForm(new CompteBancaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comptebancaire_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CompteBancaire entity.
     *
     * @Route("/{id}/delete", name="comptebancaire_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:CompteBancaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CompteBancaire entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Compte bancaire a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('comptebancaire'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
