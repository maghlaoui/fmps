<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\InscriptionOffreService;
use Acme\FmpsBundle\Form\InscriptionOffreServiceType;
use Acme\FmpsBundle\Util\FmpsLists;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * InscriptionOffreService controller.
 *
 * @Route("/inscription_offres_service")
 */
class InscriptionOffreServiceController extends Controller
{
    /**
     * Lists all InscriptionOffreService entities.
     *
     * @Route("/", name="inscriptionoffreservice")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:InscriptionOffreService');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:InscriptionOffreService:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a InscriptionOffreService entity.
     *
     * @Route("/{id}/show", name="inscriptionoffreservice_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:InscriptionOffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InscriptionOffreService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new InscriptionOffreService entity.
     *
     * @Route("/new", name="inscriptionoffreservice_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InscriptionOffreService();
				$request = $this->getRequest();
        $inscription_id = $request->query->get('inscription_id');
				if ( empty($inscription_id) )
				{
					$this->get('session')->setFlash('error', 'Vous devez choisir une inscription à payer');
					
					return $this->redirect($this->generateUrl('inscription'));
				}
				
				$em = $this->getDoctrine()->getEntityManager();
        $inscription = $em->getRepository('AcmeFmpsBundle:Inscription')->find($inscription_id);
        if ( $inscription ) $entity->setInscription($inscription);
				$entity->setInscriptionId($inscription_id);

        $form   = $this->createForm(new InscriptionOffreServiceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new InscriptionOffreService entity.
     *
     * @Route("/create", name="inscriptionoffreservice_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:InscriptionOffreService:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new InscriptionOffreService();
        $request = $this->getRequest();
        $form    = $this->createForm(new InscriptionOffreServiceType(), $entity);
        $form->bindRequest($request);
				//TODO check if user has doesn't hase this service

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inscriptionoffreservice_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing InscriptionOffreService entity.
     *
     * @Route("/{id}/edit", name="inscriptionoffreservice_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:InscriptionOffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InscriptionOffreService entity.');
        }

        $editForm = $this->createForm(new InscriptionOffreServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing InscriptionOffreService entity.
     *
     * @Route("/{id}/update", name="inscriptionoffreservice_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:InscriptionOffreService:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:InscriptionOffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InscriptionOffreService entity.');
        }

        $editForm   = $this->createForm(new InscriptionOffreServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inscriptionoffreservice_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a InscriptionOffreService entity.
     *
     * @Route("/{id}/delete", name="inscriptionoffreservice_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:InscriptionOffreService')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InscriptionOffreService entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Inscription a été supprimée avec succès');
        }

        return $this->redirect($this->generateUrl('inscriptionoffreservice'));
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
			$form = $this->createFormBuilder(new InscriptionOffreService() )
	              ->add('inscription', 'entity', array('class' => 'AcmeFmpsBundle:Inscription', 'label' => 'Inscription', 'empty_value' => '--Sélectionnez--', 'required' => false))
						    ->add('offreService', 'entity', array('class' => 'AcmeFmpsBundle:OffreService', 'label' => 'Offre de service', 'empty_value' => '--Sélectionnez--', 'required' => false))
						    ->add('mois' ,'choice' , array('choices' => FmpsLists::getMonths(), 'empty_value' => '--Sélectionnez--', 'required' => false))
								->getForm();
	        return $form;
		}
		
}
