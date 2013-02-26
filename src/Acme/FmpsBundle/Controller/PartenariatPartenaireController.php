<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\PartenariatPartenaire;
use Acme\FmpsBundle\Form\PartenariatPartenaireType;
use Acme\FmpsBundle\Form\PartenaireType;
use Acme\FmpsBundle\Form\TypeEngagementType;
use Acme\FmpsBundle\Form\TypeContributionType;
use Acme\FmpsBundle\Entity\Partenaire;
use Acme\FmpsBundle\Entity\TypeEngagement;
use Acme\FmpsBundle\Entity\TypeContribution;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * PartenariatPartenaire controller.
 *
 * @Route("/conventions")
 */
class PartenariatPartenaireController extends Controller
{
    /**
     * Lists all PartenariatPartenaire entities.
     *
     * @Route("/", name="partenariatpartenaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $form = $this->getForm();
        $request = $this->getRequest();
		    $repository = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire');

        $form->bindRequest($request);
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:PartenariatPartenaire:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a PartenariatPartenaire entity.
     *
     * @Route("/{id}/show", name="partenariatpartenaire_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartenariatPartenaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new PartenariatPartenaire entity.
     *
     * @Route("/new", name="partenariatpartenaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PartenariatPartenaire();
        
        $request = $this->getRequest();
        $partenariat_id = $request->query->get('partenariat_id');
        $this->get('session')->set('partenariat_id', $partenariat_id);
        $entity->setPartenariatId($partenariat_id);
        $form   = $this->createForm(new PartenariatPartenaireType(), $entity);

				$partenaire = new Partenaire();
        $partenaire_form = $this->createForm(new PartenaireType(), $partenaire);

				$type_engagement = new TypeEngagement();
        $type_engagement_form   = $this->createForm(new TypeEngagementType(), $type_engagement);

				$type_contribution = new TypeContribution();
        $type_contribution_form   = $this->createForm(new TypeContributionType(), $type_contribution);
		    
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'partenaire_form'   => $partenaire_form->createView(),
						'type_engagement_form'   => $type_engagement_form->createView(),
						'type_contribution_form'   => $type_contribution_form->createView()
        );
    }

    /**
     * Creates a new PartenariatPartenaire entity.
     *
     * @Route("/create", name="partenariatpartenaire_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:PartenariatPartenaire:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new PartenariatPartenaire();
        $request = $this->getRequest();
		
		    $postData = $request->request->get('partenariat_partenaire');
        $type_engagement = $postData['type_engagement'];
        $type_contribution = $postData['type_contribution'];
		    $em = $this->getDoctrine()->getEntityManager();
		
        $typeEngagement = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->findOrCreateByLibelle($type_engagement);
        $entity->setTypeEngagement($typeEngagement);

		    $typeContribution = $em->getRepository('AcmeFmpsBundle:TypeContribution')->findOrCreateByLibelle($type_contribution);
		    $entity->setTypeContribution($typeContribution);

        $form    = $this->createForm(new PartenariatPartenaireType(), $entity);
        $form->bindRequest($request);
  		
        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenaire a été ajouté au partenariat');
            
            if ($this->get('session')->get('partenariat_id')){
               $partenariat_id = $this->get('session')->get('partenariat_id');
               $this->get('session')->set('partenariat_id', null);
               return $this->redirect($this->generateUrl('partenariat_show', array('id' => $partenariat_id ))); 
            }
            else {
               return $this->redirect($this->generateUrl('partenariatpartenaire_show', array('id' => $entity->getId())));
            }
             
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing PartenariatPartenaire entity.
     *
     * @Route("/{id}/edit", name="partenariatpartenaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartenariatPartenaire entity.');
        }

        $editForm = $this->createForm(new PartenariatPartenaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing PartenariatPartenaire entity.
     *
     * @Route("/{id}/update", name="partenariatpartenaire_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:PartenariatPartenaire:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartenariatPartenaire entity.');
        }

				$request = $this->getRequest();
				$postData = $request->request->get('partenariat_partenaire');
				
        $type_engagement = $postData['type_engagement'];
        $type_contribution = $postData['type_contribution'];
		
        $typeEngagement = $em->getRepository('AcmeFmpsBundle:TypeEngagement')->findOrCreateByLibelle($type_engagement);
        $entity->setTypeEngagement($typeEngagement);

				$typeContribution = $em->getRepository('AcmeFmpsBundle:TypeContribution')->findOrCreateByLibelle($type_contribution);
				$entity->setTypeContribution($typeContribution);

        $editForm   = $this->createForm(new PartenariatPartenaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenaire Partenariat a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('partenariatpartenaire_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PartenariatPartenaire entity.
     *
     * @Route("/{id}/delete", name="partenariatpartenaire_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:PartenariatPartenaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PartenariatPartenaire entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenaire a été supprimé de la partenariat avec succès');
            
        }
        
        return $this->redirect($this->generateUrl('partenariatpartenaire'));  
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
		$form = $this->createFormBuilder(new PartenariatPartenaire() )
	                ->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->add('partenaire', 'entity', array('class' => 'AcmeFmpsBundle:Partenaire', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->add('type_engagement' ,'entity', array('class' => 'AcmeFmpsBundle:TypeEngagement', 'required' => false, 'label' => 'Type d\'engagement', 'empty_value' => '--Sélectionnez--' ))
	                ->add('type_contribution' ,'entity', array('class' => 'AcmeFmpsBundle:TypeContribution', 'required' => false, 'label' => 'Périodicité', 'empty_value' => '--Sélectionnez--' ))
	                ->getForm();
	   return $form;
	}
}
