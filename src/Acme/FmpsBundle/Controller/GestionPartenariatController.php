<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\GestionPartenariat;
use Acme\FmpsBundle\Form\GestionPartenariatType;
use Acme\FmpsBundle\Entity\Contact;
use Acme\FmpsBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * GestionPartenariat controller.
 *
 * @Route("/gestion_partenariat")
 */
class GestionPartenariatController extends Controller
{
    /**
     * Lists all GestionPartenariat entities.
     *
     * @Route("/", name="gestionpartenariat")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $form = $this->createSearchForm();
        $request = $this->getRequest();
		    $page = $this->get('request')->query->get('page', 1);
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:GestionPartenariat');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page, 15);
        
        return $this->render('AcmeFmpsBundle:GestionPartenariat:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a GestionPartenariat entity.
     *
     * @Route("/{id}/show", name="gestionpartenariat_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:GestionPartenariat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GestionPartenariat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new GestionPartenariat entity.
     *
     * @Route("/new", name="gestionpartenariat_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new GestionPartenariat();
        $request = $this->getRequest();
        $partenariat_id = $request->query->get('partenariat_id');
        $this->get('session')->set('partenariat_id', $partenariat_id);
        $entity->setPartenariatId($partenariat_id);
        $form   = $this->createForm(new GestionPartenariatType(), $entity);

				$contact = new Contact();
				$contact_form   = $this->createForm(new ContactType(), $contact);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'contact_form'   => $contact_form->createView()
        );
    }

    /**
     * Creates a new GestionPartenariat entity.
     *
     * @Route("/create", name="gestionpartenariat_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:GestionPartenariat:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new GestionPartenariat();
        $request = $this->getRequest();
        $form    = $this->createForm(new GestionPartenariatType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $partenariat_id = $request->query->get('partenariat_id');
            if ($partenariat_id != null && $partenariat_id != '') {
                $partenariat = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($partenariat_id);
                $entity->setPartenariat($partenariat);
            }
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Chargé du partenariat a été créé avec succès');
            
            if ($this->get('session')->get('partenariat_id')){
               $partenariat_id = $this->get('session')->get('partenariat_id');
               $this->get('session')->set('partenariat_id', null);
               return $this->redirect($this->generateUrl('partenariat_show', array('id' => $partenariat_id ))); 
            }
            else {
               return $this->redirect($this->generateUrl('gestionpartenariat_show', array('id' => $entity->getId())));
            }
            
        }

				$contact = new Contact();
				$contact_form   = $this->createForm(new ContactType(), $contact);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'contact_form'   => $contact_form->createView()
        );
    }

    /**
     * Displays a form to edit an existing GestionPartenariat entity.
     *
     * @Route("/{id}/edit", name="gestionpartenariat_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:GestionPartenariat')->find($id);

		$request = $this->getRequest();
        $this->get('session')->set('partenariat_id', $request->query->get('partenariat_id'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GestionPartenariat entity.');
        }

        $editForm = $this->createForm(new GestionPartenariatType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing GestionPartenariat entity.
     *
     * @Route("/{id}/update", name="gestionpartenariat_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:GestionPartenariat:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:GestionPartenariat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GestionPartenariat entity.');
        }

        $editForm   = $this->createForm(new GestionPartenariatType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Chargé du partenariat a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('gestionpartenariat_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a GestionPartenariat entity.
     *
     * @Route("/{id}/delete", name="gestionpartenariat_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:GestionPartenariat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GestionPartenariat entity.');
            }

            $em->remove($entity);
            $em->flush();
						
						$this->get('session')->setFlash('notice', 'Gestion de partenariat a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('gestionpartenariat'));    
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
	
	private function createSearchForm()
	{
		return $this->createFormBuilder(new GestionPartenariat() )
	                ->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 
				'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->add('contact', 'entity', array('class' => 'AcmeFmpsBundle:Contact', 'required' => false, 
				'empty_value' => '--Sélectionnez--'))
	                ->add('dateAffectationGestion', 'date', array('label' => 'Date de début', 'required' => false, 'widget' => 'single_text', 
				'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'Date de début')))
	                ->add('dateFinAffectationGestion', 'date', array('label' => 'Date de fin', 'required' => false, 'widget' => 'single_text', 
				'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'Date de fin')))
	                ->getForm();
	}
	
	private function getRedirectLink($id)
	{
		if ($this->get('session')->get('partenariat_id')){
           $partenariat_id = $this->get('session')->get('partenariat_id');
           $this->get('session')->set('partenariat_id', null);
           return $this->generateUrl('partenariat_show', array('id' => $partenariat_id ));
        }
        else {
           return $this->generateUrl('suiviargpart_show', array('id' => $id));
        }
	}
}
