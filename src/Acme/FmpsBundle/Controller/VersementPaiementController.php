<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\VersementPaiement;
use Acme\FmpsBundle\Form\VersementPaiementType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * VersementPaiement controller.
 *
 * @Route("/versements_paiements")
 */
class VersementPaiementController extends Controller
{
    /**
     * Lists all VersementPaiement entities.
     *
     * @Route("/", name="versementpaiement")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:VersementPaiement')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a VersementPaiement entity.
     *
     * @Route("/{id}/show", name="versementpaiement_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:VersementPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VersementPaiement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new VersementPaiement entity.
     *
     * @Route("/new", name="versementpaiement_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VersementPaiement();
        $form   = $this->createForm(new VersementPaiementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new VersementPaiement entity.
     *
     * @Route("/create", name="versementpaiement_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:VersementPaiement:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new VersementPaiement();
        $request = $this->getRequest();
        $form    = $this->createForm(new VersementPaiementType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('versementpaiement_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing VersementPaiement entity.
     *
     * @Route("/{id}/edit", name="versementpaiement_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:VersementPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VersementPaiement entity.');
        }

        $editForm = $this->createForm(new VersementPaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VersementPaiement entity.
     *
     * @Route("/{id}/update", name="versementpaiement_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:VersementPaiement:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:VersementPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VersementPaiement entity.');
        }

        $editForm   = $this->createForm(new VersementPaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('versementpaiement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a VersementPaiement entity.
     *
     * @Route("/{id}/delete", name="versementpaiement_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:VersementPaiement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VersementPaiement entity.');
            }

            $em->remove($entity);
            $em->flush();
						
						$this->get('session')->setFlash('notice', 'Versement a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('versementpaiement'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
