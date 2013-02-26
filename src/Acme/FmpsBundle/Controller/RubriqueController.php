<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Rubrique;
use Acme\FmpsBundle\Form\RubriqueType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Rubrique controller.
 *
 * @Route("/rubriques")
 */
class RubriqueController extends Controller
{
    /**
     * Lists all Rubrique entities.
     *
     * @Route("/", name="rubrique")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $request = $this->getRequest();
		    $form = $this->getForm();
		    $current_page = $this->get('request')->query->get('page', 1);
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Rubrique');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $current_page,15);
       
        return $this->render('AcmeFmpsBundle:Rubrique:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Rubrique entity.
     *
     * @Route("/{id}/show", name="rubrique_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Rubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubrique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Rubrique entity.
     *
     * @Route("/new", name="rubrique_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Rubrique();
        $form   = $this->createForm(new RubriqueType(), $entity);
        
        $request = $this->getRequest();
        $back_url = $request->query->get('back_url');
        $this->get('session')->set('back_url', $back_url);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Rubrique entity.
     *
     * @Route("/create", name="rubrique_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Rubrique:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Rubrique();
        $request = $this->getRequest();
        $form    = $this->createForm(new RubriqueType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Rubrique a été créé avec succès');
						if ( $this->get('session')->get('back_url') ) {
							$this->get('session')->set('back_url', null);
							return $this->redirect($this->generateUrl('boncommande_new'));
						}
						else {
							
						}
            return $this->redirect($this->generateUrl('rubrique_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Rubrique entity.
     *
     * @Route("/{id}/edit", name="rubrique_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Rubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubrique entity.');
        }

        $editForm = $this->createForm(new RubriqueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Rubrique entity.
     *
     * @Route("/{id}/update", name="rubrique_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Rubrique:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Rubrique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubrique entity.');
        }

        $editForm   = $this->createForm(new RubriqueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Rubrique a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('rubrique_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Rubrique entity.
     *
     * @Route("/{id}/delete", name="rubrique_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Rubrique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rubrique entity.');
            }
            
            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Rubrique a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('rubrique'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

	private function getForm()
	{
		$form = $this->createFormBuilder(new Rubrique() )
                ->add('intitule', 'text', array('required' => false, 'attr' => array('placeholder' => 'Intitulé', 'class' => 'span2')))
                ->add('chapitre', 'text', array('required' => false, 'attr' => array('placeholder' => 'Chapitre', 'class' => 'span2')))
                ->add('article', 'text', array('required' => false, 'attr' => array('placeholder' => 'Article', 'class' => 'span2')))
                ->add('paragraphe', 'text', array('required' => false, 'attr' => array('placeholder' => 'Paragraphe', 'class' => 'span2')))
                ->add('ammortissable', 'choice',  array('choices' => array(1 => 'Oui', 0 => 'Non'), 'label' => 'Amortissable', 
				'required'  => false, 'empty_value' => '--Sélectionnez--', 'attr' => array('class' => 'span2')))
                ->add('dureeAmmortissement', 'text', array('attr' => array('placeholder' => "Durée d'amortissement", 'class' => 'span2'), 'required'  => false))
                ->getForm();
			return $form;
	}
}
