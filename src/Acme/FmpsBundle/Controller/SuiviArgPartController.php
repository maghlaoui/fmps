<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\SuiviArgPart;
use Acme\FmpsBundle\Form\SuiviArgPartType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * SuiviArgPart controller.
 *
 * @Route("/contributions")
 */
class SuiviArgPartController extends Controller
{
    /**
     * Lists all SuiviArgPart entities.
     *
     * @Route("/", name="suiviargpart")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $request = $this->getRequest();
		    $form = $this->createSearchForm();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:SuiviArgPart');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:SuiviArgPart:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
   
    }

    /**
     * Finds and displays a SuiviArgPart entity.
     *
     * @Route("/{id}/show", name="suiviargpart_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:SuiviArgPart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuiviArgPart entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new SuiviArgPart entity.
     *
     * @Route("/new", name="suiviargpart_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SuiviArgPart();
        $request = $this->getRequest();
        $partenariat_partenaire_id = $request->query->get('partenariat_partenaire_id');
        $this->get('session')->set('partenariat_partenaire_id', $partenariat_partenaire_id);

		$partenariat_id = $request->query->get('partenariat_id');
        $this->get('session')->set('partenariat_id', $partenariat_id);

        $entity->setPartenariatPartenaireId($partenariat_partenaire_id);
       
        $form   = $this->createForm(new SuiviArgPartType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new SuiviArgPart entity.
     *
     * @Route("/create", name="suiviargpart_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:SuiviArgPart:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new SuiviArgPart();
        $request = $this->getRequest();
        $form    = $this->createForm(new SuiviArgPartType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Contribution reçue a été créé avec succès');
            return $this->redirect($this->getRedirectLink($entity->getId()));
           
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing SuiviArgPart entity.
     *
     * @Route("/{id}/edit", name="suiviargpart_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:SuiviArgPart')->find($id);

		$request = $this->getRequest();
        $this->get('session')->set('partenariat_id', $request->query->get('partenariat_id'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuiviArgPart entity.');
        }

        $editForm = $this->createForm(new SuiviArgPartType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SuiviArgPart entity.
     *
     * @Route("/{id}/update", name="suiviargpart_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:SuiviArgPart:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:SuiviArgPart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuiviArgPart entity.');
        }

        $editForm   = $this->createForm(new SuiviArgPartType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
			//$p = $entity->getPartenariatPartenaire();
			//$p->setMontantRecu(3232323);
			//$em->persist($p);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Contribution reçue a été mis à jour avec succès');

            return $this->redirect($this->getRedirectLink($id));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SuiviArgPart entity.
     *
     * @Route("/{id}/delete", name="suiviargpart_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid() || $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:SuiviArgPart')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SuiviArgPart entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Suivi de contribution a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('suiviargpart')); 
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
		$form = $this->createFormBuilder(new SuiviArgPart() )
                ->add('partenariatPartenaire', 'entity', array('class' => 'AcmeFmpsBundle:PartenariatPartenaire', 'label' => 'Partenaire', 
				'empty_value' => '--Sélectionnez--', 'required' => false))
                ->add('montant', 'text', array('required' => false, 'attr' => array('placeholder' => 'Montant')))
                ->add('dateReception', 'date', array('label' => 'Date de réception', 'required' => false, 'widget' => 'single_text',
 				'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'Date de réception')))
                ->getForm();
		return $form;
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
