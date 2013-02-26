<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EmployeFonction;
use Acme\FmpsBundle\Form\EmployeFonctionType;
use Symfony\Component\HttpFoundation\Response;
use Acme\FmpsBundle\Form\FonctionType;
use Acme\FmpsBundle\Entity\Fonction;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EmployeFonction controller.
 *
 * @Route("/employes_fonction")
 */
class EmployeFonctionController extends Controller
{
    /**
     * Lists all EmployeFonction entities.
     *
     * @Route("/", name="employefonction")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$repository = $em->getRepository('AcmeFmpsBundle:EmployeFonction');
				$form = $this->getForm();
				$request = $this->getRequest();
				$paginator = $this->get('knp_paginator');
				$current_page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $current_page,15);
        
        return $this->render('AcmeFmpsBundle:EmployeFonction:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a EmployeFonction entity.
     *
     * @Route("/{id}/show", name="employefonction_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeFonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeFonction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EmployeFonction entity.
     *
     * @Route("/new", name="employefonction_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EmployeFonction();

        $employeId = $this->getRequest()->query->get('employe_id');

				if ( !empty($employeId) ){
					$em = $this->getDoctrine()->getEntityManager();
					$employe = $em->getRepository('AcmeFmpsBundle:Employe')->find($employeId);
					$entity->setEmploye($employe);
				}
				
        $form   = $this->createForm(new EmployeFonctionType(), $entity);

	      $fonction_form = $this->createForm(new FonctionType(), new Fonction());

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'fonction_form' => $fonction_form->createView(),
        );
    }

    /**
     * Creates a new EmployeFonction entity.
     *
     * @Route("/create", name="employefonction_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeFonction:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EmployeFonction();
        $request = $this->getRequest();
        $form    = $this->createForm(new EmployeFonctionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($entity);
            
						$employe = $entity->getEmploye();
				    $fonction = $employe->getRecentFonction();
				
						if ( $fonction ){
						  $employe->setFonction($fonction->getFonction());
					    $em->persist($employe);
					  }
					
					  $em->flush();
            
            $this->get('session')->setFlash('notice', 'Fonction a été créé avec succès');
            
            $employeId = $entity->getEmploye()->getId();
            return $this->redirect($this->generateUrl('employe_show', array('id' => $employeId)));
            
        }
				
				$fonction_form = $this->createForm(new FonctionType(), new Fonction());
				
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'fonction_form'   => $fonction_form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EmployeFonction entity.
     *
     * @Route("/{id}/edit", name="employefonction_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeFonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeFonction entity.');
        }

				$return = $this->getRequest()->query->get('return');
        $this->get('session')->set('return', $return);

        $editForm = $this->createForm(new EmployeFonctionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
				$fonction_form = $this->createForm(new FonctionType(), new Fonction());

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
						'fonction_form'   => $fonction_form->createView()
        );
    }

    /**
     * Edits an existing EmployeFonction entity.
     *
     * @Route("/{id}/update", name="employefonction_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeFonction:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeFonction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeFonction entity.');
        }

        $editForm   = $this->createForm(new EmployeFonctionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
	
            $em->persist($entity);

            $employe = $entity->getEmploye();
				    $fonction = $employe->getRecentFonction();
				
						if ( $fonction ){
						  $employe->setFonction($fonction->getFonction());
					    $em->persist($employe);
					  }
					
					  $em->flush();
            
            $this->get('session')->setFlash('notice', 'Fonction a été mis à jour avec succès');

						$return = $this->get('session')->get('return');
		        if ( !empty( $return )){
			        $this->get('session')->set('return', null);
			        return $this->redirect($this->generateUrl('employe_show', array('id' => $entity->getEmployeId())));
		        }
		
            return $this->redirect($this->generateUrl('employefonction_show', array('id' => $id)));
        }

				$fonction_form = $this->createForm(new FonctionType(), new Fonction());
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
						'fonction_form' => $fonction_form->createView(),
        );
    }

    /**
     * Deletes a EmployeFonction entity.
     *
     * @Route("/{id}/delete", name="employefonction_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid() || $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EmployeFonction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmployeFonction entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'EmployeFonction a été supprimé avec succès');
        }
        if($request->isXmlHttpRequest())
        {
            $response = new Response(json_encode(array(	'success'=> 1,)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        else 
        {
            return $this->redirect($this->generateUrl('employefonction'));
        }
        
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
		$form = $this->createFormBuilder(new EmployeFonction() )
                ->add('fonction', 'entity', array('class' => 'AcmeFmpsBundle:Fonction', 'label' => 'Fonction', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->add('dateDebutFonction', 'date', array('label' => "Date de début", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
                ->add('dateFinFonction', 'date', array('label' => "Date de fin", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
                
                ->getForm();
        return $form;
	}
}
