<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EmployeAbsence;
use Acme\FmpsBundle\Form\EmployeAbsenceType;
use Acme\FmpsBundle\Util\FmpsLists;
use Acme\FmpsBundle\Entity\Employe;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EmployeAbsence controller.
 *
 * @Route("/absences")
 */
class EmployeAbsenceController extends Controller
{
    /**
     * Lists all EmployeAbsence entities.
     *
     * @Route("/", name="employeabsence")
     * @Template()
     */
    public function indexAction()
    {
	
			$em = $this->getDoctrine()->getEntityManager();
      $repository = $em->getRepository('AcmeFmpsBundle:EmployeAbsence');
      $paginator = $this->get('knp_paginator');
      $request = $this->getRequest();
      $form = $this->getForm();
      $form->bindRequest($request);
      $page = $this->get('request')->query->get('page', 1);
			$user = $this->get('security.context')->getToken()->getUser();
      $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page, 15);

      return $this->render('AcmeFmpsBundle:EmployeAbsence:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
       
    }

    /**
     * Finds and displays a EmployeAbsence entity.
     *
     * @Route("/{id}/show", name="employeabsence_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeAbsence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EmployeAbsence entity.
     *
     * @Route("/new", name="employeabsence_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EmployeAbsence();
				$request = $this->getRequest();
        $employeId = $request->query->get('employe_id');
				$em = $this->getDoctrine()->getEntityManager();

				$employe = $em->getRepository('AcmeFmpsBundle:Employe')->find($employeId);
        if ($employe instanceof Employe) $entity->setEmploye($employe);

				$user = $this->get('security.context')->getToken()->getUser();
				$employes = $user->getEmployes();

        $form   = $this->createForm(new EmployeAbsenceType(), $entity, array('employes' => $employes));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EmployeAbsence entity.
     *
     * @Route("/create", name="employeabsence_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeAbsence:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EmployeAbsence();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
				$employes = $user->getEmployes();
        $form    = $this->createForm(new EmployeAbsenceType(), $entity, array('employes' => $employes));
        $form->bindRequest($request);

				$em = $this->getDoctrine()->getEntityManager();
				

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

						$count = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->getCount($entity);
						
						if ( $count > 0 ){
							$this->get('session')->setFlash('error', 'Employe a déjà une absence dans cette date');
							return $this->redirect($this->generateUrl('employeabsence'));
						}
						
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Absence a été ajouté avec succès');

            return $this->redirect($this->generateUrl('employeabsence_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EmployeAbsence entity.
     *
     * @Route("/{id}/edit", name="employeabsence_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeAbsence entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
				$employes = $user->getEmployes();

        $editForm = $this->createForm(new EmployeAbsenceType(), $entity, array('employes' => $employes));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EmployeAbsence entity.
     *
     * @Route("/{id}/update", name="employeabsence_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeAbsence:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeAbsence entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
				$employes = $user->getEmployes();
        $editForm   = $this->createForm(new EmployeAbsenceType(), $entity, array('employes' => $employes));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
	
					  $count = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->getCount($entity);
					  if ( $count > 1 ){
						  $this->get('session')->setFlash('error', 'Employe a déjà une absence dans cette date');
						  return $this->redirect($this->generateUrl('employeabsence'));
					  }
					
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Absence a été modifié avec succès');

            return $this->redirect($this->generateUrl('employeabsence_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EmployeAbsence entity.
     *
     * @Route("/{id}/delete", name="employeabsence_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EmployeAbsence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmployeAbsence entity.');
            }

            $em->remove($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Absence a été supprimé avec succès');
        }
				
        return $this->redirect($this->generateUrl('employeabsence'));
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
			$form = $this->createFormBuilder(new EmployeAbsence() )
	                ->add('employeId', 'text', array('label' => 'Employé', 'required' => false, 'attr' => array('placeholder' => 'Nom')))
									->add('motif', 'choice', array('choices' => FmpsLists::getDefaultMotifs(), 'empty_value' => '--Sélectionnez--', 'required'  => false))
	                ->add('du', 'date', array('label' => "Du", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
	                ->add('au', 'date', array('label' => "Au", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))

	                ->getForm();
	        return $form;
		}
}
