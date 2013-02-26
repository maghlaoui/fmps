<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\ReseauPrescolaire;
use Acme\FmpsBundle\Form\ReseauPrescolaireType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ReseauPrescolaire controller.
 *
 * @Route("/reseaux_prescolaire")
 */
class ReseauPrescolaireController extends Controller
{
    /**
     * Lists all ReseauPrescolaire entities.
     *
     * @Route("/", name="reseauprescolaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->createSearchForm();
      
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:ReseauPrescolaire');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1),15);
       
        return $this->render('AcmeFmpsBundle:ReseauPrescolaire:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a ReseauPrescolaire entity.
     *
     * @Route("/{id}/show", name="reseauprescolaire_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ReseauPrescolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReseauPrescolaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ReseauPrescolaire entity.
     *
     * @Route("/new", name="reseauprescolaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ReseauPrescolaire();
        $form   = $this->createForm(new ReseauPrescolaireType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ReseauPrescolaire entity.
     *
     * @Route("/create", name="reseauprescolaire_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ReseauPrescolaire:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ReseauPrescolaire();
        $request = $this->getRequest();
        $form    = $this->createForm(new ReseauPrescolaireType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Réseau préscolaire a été créé avec succès');

            return $this->redirect($this->generateUrl('reseauprescolaire_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ReseauPrescolaire entity.
     *
     * @Route("/{id}/edit", name="reseauprescolaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ReseauPrescolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReseauPrescolaire entity.');
        }

        $editForm = $this->createForm(new ReseauPrescolaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ReseauPrescolaire entity.
     *
     * @Route("/{id}/update", name="reseauprescolaire_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ReseauPrescolaire:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ReseauPrescolaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReseauPrescolaire entity.');
        }

        $editForm   = $this->createForm(new ReseauPrescolaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Réseau préscolaire a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('reseauprescolaire_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ReseauPrescolaire entity.
     *
     * @Route("/{id}/delete", name="reseauprescolaire_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:ReseauPrescolaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ReseauPrescolaire entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Réseau préscolaire a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('reseauprescolaire'));
        
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

	private function createSearchForm()
	{
		return $this->createFormBuilder(new ReseauPrescolaire() )
                ->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 
											'required'  => false, 'empty_value' => '--Sélectionnez--'))
								->add('libelleReseauPrescolaire', 'text', array('label' => 'Libellé', 'required' => false, 
											'attr' => array('placeholder' => 'Libellé')))
                ->getForm();
	}
}
