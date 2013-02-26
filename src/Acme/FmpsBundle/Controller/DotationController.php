<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Dotation;
use Acme\FmpsBundle\Form\DotationType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Dotation controller.
 *
 * @Route("/dotations")
 */
class DotationController extends Controller
{
    /**
     * Lists all Dotation entities.
     *
     * @Route("/", name="dotation")
     * @Template()
     */
    public function indexAction()
    {
       $em = $this->getDoctrine()->getEntityManager();
       $paginator = $this->get('knp_paginator');
       $request = $this->getRequest();
       $form = $this->getForm();
       
       $form->bindRequest($request);
       $repository = $em->getRepository('AcmeFmpsBundle:Dotation');
       $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1),15);
       
       return $this->render('AcmeFmpsBundle:Dotation:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Dotation entity.
     *
     * @Route("/{id}/show", name="dotation_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Dotation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dotation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Dotation entity.
     *
     * @Route("/new", name="dotation_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Dotation();
        $entity->setAnnee(Date('Y'));
        $form   = $this->createForm(new DotationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Dotation entity.
     *
     * @Route("/create", name="dotation_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Dotation:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Dotation();
        $request = $this->getRequest();
        $form    = $this->createForm(new DotationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Dotation a été créé avec succès');
            return $this->redirect($this->generateUrl('dotation_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Dotation entity.
     *
     * @Route("/{id}/edit", name="dotation_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Dotation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dotation entity.');
        }

        $editForm = $this->createForm(new DotationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Dotation entity.
     *
     * @Route("/{id}/update", name="dotation_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Dotation:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Dotation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dotation entity.');
        }

        $editForm   = $this->createForm(new DotationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Dotation a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('dotation_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Dotation entity.
     *
     * @Route("/{id}/delete", name="dotation_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Dotation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dotation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

				$this->get('session')->setFlash('notice', 'Dotation a été supprimé avec succès');
        return $this->redirect($this->generateUrl('dotation'));
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
			$form = $this->createFormBuilder(new Dotation() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) 
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where('e.id > 1');
		                     }
		                     ))
	                ->add('annee', 'text', array('label' => 'Année', 'required' => false, 'attr' => array('placeholder' => 'Année')))
									->add('periode', 'text', array('label' => 'Période', 'required' => false, 'attr' => array('placeholder' => 'Période')))
	                ->add('montant', 'text', array('required' => false, 'attr' => array('placeholder' => 'Montant')))
	                
	                ->getForm();
				return $form;
		}
}
