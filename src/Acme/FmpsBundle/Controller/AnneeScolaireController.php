<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\AnneeScolaire;
use Acme\FmpsBundle\Form\AnneeScolaireType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * AnneeScolaire controller.
 *
 * @Route("/annees_scolaire")
 */
class AnneeScolaireController extends Controller
{
    /**
     * Lists all AnneeScolaire entities.
     *
     * @Route("/", name="anneescolaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT a FROM AcmeFmpsBundle:AnneeScolaire a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:AnneeScolaire:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a AnneeScolaire entity.
     *
     * @Route("/{id}/show", name="anneescolaire_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:AnneeScolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnneeScolaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new AnneeScolaire entity.
     *
     * @Route("/new", name="anneescolaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AnneeScolaire();
        $form   = $this->createForm(new AnneeScolaireType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new AnneeScolaire entity.
     *
     * @Route("/create", name="anneescolaire_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:AnneeScolaire:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new AnneeScolaire();
        $request = $this->getRequest();
        $form    = $this->createForm(new AnneeScolaireType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Année scolaire a été créé avec succès');

            return $this->redirect($this->generateUrl('anneescolaire_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing AnneeScolaire entity.
     *
     * @Route("/{id}/edit", name="anneescolaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:AnneeScolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnneeScolaire entity.');
        }

        $editForm = $this->createForm(new AnneeScolaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing AnneeScolaire entity.
     *
     * @Route("/{id}/update", name="anneescolaire_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:AnneeScolaire:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:AnneeScolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnneeScolaire entity.');
        }

        $editForm   = $this->createForm(new AnneeScolaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Année scolaire a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('anneescolaire_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a AnneeScolaire entity.
     *
     * @Route("/{id}/delete", name="anneescolaire_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:AnneeScolaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnneeScolaire entity.');
            }

						if ( count($entity->getOffresServices()) > 0 ){
							$this->get('session')->setFlash('error', 'Impossible de supprimer cette année scolaire');
							return $this->redirect($this->generateUrl('anneescolaire'));
						}
						
            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Année scolaire a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('anneescolaire'));     
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
