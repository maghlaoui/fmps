<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Titeur;
use Acme\FmpsBundle\Form\TiteurType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Titeur controller.
 *
 * @Route("/tuteurs")
 */
class TiteurController extends Controller
{
    /**
     * Lists all Titeur entities.
     *
     * @Route("/", name="titeur")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
		    $form = $this->createSearchForm();
	    	$page = $this->get('request')->query->get('page', 1);
		
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Titeur');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,15);
        
        return $this->render('AcmeFmpsBundle:Titeur:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Titeur entity.
     *
     * @Route("/{id}/show", name="titeur_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Titeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titeur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Titeur entity.
     *
     * @Route("/new", name="titeur_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Titeur();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new TiteurType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Titeur entity.
     *
     * @Route("/create", name="titeur_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Titeur:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Titeur();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new TiteurType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->set('titeur_id', $entity->getId());
						$this->get('session')->setFlash('notice', 'Titeur a été ajouté avec succès');

            return $this->redirect($this->generateUrl('enfant_new'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Titeur entity.
     *
     * @Route("/{id}/edit", name="titeur_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Titeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titeur entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new TiteurType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Titeur entity.
     *
     * @Route("/{id}/update", name="titeur_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Titeur:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Titeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titeur entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new TiteurType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

			$this->get('session')->setFlash('notice', 'Titeur a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('titeur_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Titeur entity.
     *
     * @Route("/{id}/delete", name="titeur_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Titeur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Titeur entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Titeur a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('titeur'));
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
			$form = $this->createFormBuilder(new Titeur() )
	                ->add('nom', 'text', array('required' => false, 'attr' => array('placeholder' => 'Nom')))
	                ->add('prenom', 'text', array('required' => false, 'attr' => array('placeholder' => 'Prénom')))
	                ->add('cin', 'text', array('required' => false, 'attr' => array('placeholder' => 'Cin')))
									->add('profession', 'text', array('required' => false, 'attr' => array('placeholder' => 'Profession')))
									->add('ville', 'entity', array('class' => 'AcmeFmpsBundle:Ville', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->getForm();
	        return $form;
		}
}
