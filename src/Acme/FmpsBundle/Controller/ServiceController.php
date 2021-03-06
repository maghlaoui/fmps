<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Service;
use Acme\FmpsBundle\Form\ServiceType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Service controller.
 *
 * @Route("/services")
 */
class ServiceController extends Controller
{
    /**
     * Lists all Service entities.
     *
     * @Route("/", name="service")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT s FROM AcmeFmpsBundle:Service s";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities  = $paginator->paginate($query, $this->get('request')->query->get('page', 1),25);

        return $this->render('AcmeFmpsBundle:Service:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a Service entity.
     *
     * @Route("/{id}/show", name="service_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Service entity.
     *
     * @Route("/new", name="service_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Service();
        $form   = $this->createForm(new ServiceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Service entity.
     *
     * @Route("/create", name="service_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Service:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Service();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServiceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Service a été créé avec succès');

            return $this->redirect($this->generateUrl('service_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     * @Route("/{id}/edit", name="service_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Service entity.
     *
     * @Route("/{id}/update", name="service_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Service:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm   = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Service a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('service_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Service entity.
     *
     * @Route("/{id}/delete", name="service_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }

						if ( count($entity->getOffresServices()) > 0 ){
							$this->get('session')->setFlash('error', 'Impossible de supprimer ce service');
							
							return $this->redirect($this->generateUrl('service'));
						}

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Service a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('service'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
