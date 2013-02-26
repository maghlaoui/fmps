<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Partenariat;
use Acme\FmpsBundle\Form\PartenariatType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Partenariat controller.
 *
 * @Route("/partenariats")
 */
class PartenariatController extends Controller
{
    /**
     * Lists all Partenariat entities.
     *
     * @Route("/", name="partenariat")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $paginator = $this->get('knp_paginator');
        $form = $this->getForm();
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Partenariat');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
       
        return $this->render('AcmeFmpsBundle:Partenariat:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Partenariat entity.
     *
     * @Route("/{id}/show", name="partenariat_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenariat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $partenaires = $entity->getPartenariatsPartenaires();
        $gestionPartenariats = $entity->getGestionPartenariats();
        $documents = $entity->getDocuments();
		$contributions = $em->getRepository('AcmeFmpsBundle:SuiviArgPart')->getcontributions($id);
		
        return array(
            'entity'      => $entity,
            'partenaires' => $partenaires,
            'gestionPartenariats' => $gestionPartenariats,
            'documents' => $documents,
						'contributions' => $contributions,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Partenariat entity.
     *
     * @Route("/new", name="partenariat_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Partenariat();
        $form   = $this->createForm(new PartenariatType(), $entity);
       
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Partenariat entity.
     *
     * @Route("/create", name="partenariat_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Partenariat:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Partenariat();
        $request = $this->getRequest();
        $form    = $this->createForm(new PartenariatType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);

            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenariat a été créé avec succès');

            return $this->redirect($this->generateUrl('partenariat_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Partenariat entity.
     *
     * @Route("/{id}/edit", name="partenariat_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenariat entity.');
        }

        $editForm = $this->createForm(new PartenariatType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Partenariat entity.
     *
     * @Route("/{id}/update", name="partenariat_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Partenariat:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenariat entity.');
        }

        $editForm   = $this->createForm(new PartenariatType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenariat a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('partenariat_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Partenariat entity.
     *
     * @Route("/{id}/delete", name="partenariat_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $request = $this->getRequest();   
        $form = $this->createDeleteForm($id);
        
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Partenariat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partenariat entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Partenariat a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('partenariat'));
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
		 $form = $this->createFormBuilder(new Partenariat() )
                ->add('libellePartenariat', 'text', array('label' => 'Libellé', 'required' => false, 'attr' => array('placeholder' => 'Libellé')))
                ->add('datePatenariat', 'date', array('label' => 'Date de début', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 
				'attr' => array('class' => 'date', 'placeholder' => 'Date de début')))
                ->add('dateFinPartenariat', 'date', array('label' => 'Date de fin', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 
				'attr' => array('class' => 'date', 'placeholder' => 'Date de fin')))
                ->add('objetPartenariat', 'text', array('label' => 'Objet de participation', 'required' => false, 'attr' => array('placeholder' => 'Objet de participation')))
                ->getForm();
	     return $form;
	}
	
	private function getPpForm()
	{
		$form = $this->createFormBuilder(new \Acme\FmpsBundle\Entity\PartenariatPartenaire() )
	                ->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->add('partenaire', 'entity', array('class' => 'AcmeFmpsBundle:Partenaire', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->add('type_engagement' ,'entity', array('class' => 'AcmeFmpsBundle:TypeEngagement', 'required' => false, 'label' => 'Type d\'engagement', 'empty_value' => '--Sélectionnez--' ))
	                ->add('montantParticipation', 'text', array('label' => 'Montant de participation', 'required' => false))
	                ->add('type_contribution' ,'entity', array('class' => 'AcmeFmpsBundle:TypeContribution', 'required' => false, 'label' => 'Périodicité', 'empty_value' => '--Sélectionnez--' ))
	                ->getForm();
	   return $form;
	}
	
	/**
     * Partenariat dashboard.
     *
     * @Route("/dashboard", name="partenariat_dashboard")
     * @Template()
     */
    public function dashboardAction(){
			$em = $this->getDoctrine()->getEntityManager();
      $paginator = $this->get('knp_paginator');
        
      $request = $this->getRequest();
		  $form = $this->getPpForm();
		  $repository = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        }
        else
        {
            $entities = $paginator->paginate($repository->getPartenariatsDetails(), $this->get('request')->query->get('page', 1),15);
        }
        
        return $this->render('AcmeFmpsBundle:Partenariat:dashboard.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
		
	}
}
