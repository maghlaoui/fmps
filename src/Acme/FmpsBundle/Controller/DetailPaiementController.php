<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\DetailPaiement;
use Acme\FmpsBundle\Form\DetailPaiementType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * DetailPaiement controller.
 *
 * @Route("/detail_paiements")
 */
class DetailPaiementController extends Controller
{
    /**
     * Lists all DetailPaiement entities.
     *
     * @Route("/", name="detailpaiement")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:DetailPaiement')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a DetailPaiement entity.
     *
     * @Route("/{id}/show", name="detailpaiement_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:DetailPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailPaiement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new DetailPaiement entity.
     *
     * @Route("/new", name="detailpaiement_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DetailPaiement();
        $form   = $this->createForm(new DetailPaiementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new DetailPaiement entity.
     *
     * @Route("/create", name="detailpaiement_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:DetailPaiement:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new DetailPaiement();
        $request = $this->getRequest();
        $form    = $this->createForm(new DetailPaiementType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detailpaiement_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing DetailPaiement entity.
     *
     * @Route("/{id}/edit", name="detailpaiement_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:DetailPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailPaiement entity.');
        }

        $editForm = $this->createForm(new DetailPaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DetailPaiement entity.
     *
     * @Route("/{id}/update", name="detailpaiement_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:DetailPaiement:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:DetailPaiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailPaiement entity.');
        }

        $editForm   = $this->createForm(new DetailPaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detailpaiement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DetailPaiement entity.
     *
     * @Route("/{id}/delete", name="detailpaiement_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:DetailPaiement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DetailPaiement entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Détail de paiement a été supprimé avec succés');
        }

        return $this->redirect($this->generateUrl('detailpaiement'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
