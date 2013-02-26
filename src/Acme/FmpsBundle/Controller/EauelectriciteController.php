<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Eauelectricite;
use Acme\FmpsBundle\Form\EauelectriciteType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Eauelectricite controller.
 *
 * @Route("/eau_electricite")
 */
class EauelectriciteController extends Controller
{
    /**
     * Lists all Eauelectricite entities.
     *
     * @Route("/", name="eauelectricite")
     * @Template()
     */
    public function indexAction()
    {
				$em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->createSearchForm();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Eauelectricite');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $request->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:Eauelectricite:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Eauelectricite entity.
     *
     * @Route("/{id}/show", name="eauelectricite_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Eauelectricite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eauelectricite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Eauelectricite entity.
     *
     * @Route("/new", name="eauelectricite_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Eauelectricite();
				$entity->setPenalite(0);
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EauelectriciteType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Eauelectricite entity.
     *
     * @Route("/create", name="eauelectricite_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Eauelectricite:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Eauelectricite();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EauelectriciteType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Facture a été créé avec succès');

            return $this->redirect($this->generateUrl('eauelectricite_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Eauelectricite entity.
     *
     * @Route("/{id}/edit", name="eauelectricite_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Eauelectricite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eauelectricite entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EauelectriciteType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Eauelectricite entity.
     *
     * @Route("/{id}/update", name="eauelectricite_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Eauelectricite:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Eauelectricite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eauelectricite entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EauelectriciteType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Facture a été modifié avec succès');

            return $this->redirect($this->generateUrl('eauelectricite_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Eauelectricite entity.
     *
     * @Route("/{id}/delete", name="eauelectricite_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Eauelectricite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Eauelectricite entity.');
            }

            $em->remove($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Facture a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('eauelectricite'));
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
			$user = $this->get('security.context')->getToken()->getUser();
			$ecoles = $user->getEcoles();
		  if ( !empty($ecoles) && !in_array(1, $ecoles) )
		  {
		     $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
				 $where1 = 'b.id IN (SELECT eb.budgetId FROM Acme\FmpsBundle\Entity\EcoleBudget eb WHERE eb.ecoleId IN (' . implode(', ', $ecoles) . '))';
		  }
		  else{
		     $where = 'e.id > 1';
				 $where1 = 'b.id IN (SELECT eb.budgetId FROM Acme\FmpsBundle\Entity\EcoleBudget eb WHERE eb.ecoleId > 1)';
		  }
		
			$form = $this->createFormBuilder(new Eauelectricite() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
		              ->add('budget', 'entity', array('class' => 'AcmeFmpsBundle:Budget', 'label' => 'Budget', 'empty_value' => '--Sélectionnez--',
									 'required' => false, 
						                'query_builder' => function (EntityRepository $er) use ($where1)
						                     {
						                         return $er->createQueryBuilder('b')
						                                ->where($where1);
						                     }
						                     ))
	                ->add('numfacture', 'text', array('label' => 'Numéro de facture', 'required' => false, 'attr' => array('placeholder' => 'Numéro de facture')))
	                ->add('fournisseur', 'text', array('required' => false, 'attr' => array('placeholder' => 'Fournisseur')))
	                ->getForm();
				return $form;
		}
}
