<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Budget;
use Acme\FmpsBundle\Entity\EcoleBudget;
use Acme\FmpsBundle\Form\BudgetType;
use Acme\FmpsBundle\Util\FmpsLists;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Budget controller.
 *
 * @Route("/budgets")
 */
class BudgetController extends Controller
{
    /**
     * Lists all Budget entities.
     *
     * @Route("/", name="budget")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$repository = $em->getRepository('AcmeFmpsBundle:Budget');
				$form = $this->getForm();
				$request = $this->getRequest();
				$paginator = $this->get('knp_paginator');
				$page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,15);
        
        return $this->render('AcmeFmpsBundle:Budget:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Budget entity.
     *
     * @Route("/{id}/show", name="budget_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Budget')->find($id);
				$entities = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->findByBudgetId($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
						'entities'    => $entities,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Budget entity.
     *
     * @Route("/new", name="budget_new")
     * @Template()
     */
    public function newAction()
    {
			  $em = $this->getDoctrine()->getEntityManager();
	
        $entity = new Budget();
        $entity->setAnnee(Date('Y'));
        $form   = $this->createForm(new BudgetType(), $entity);
				$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findAll();

        return array(
            'entity' => $entity,
						'ecoles' => $ecoles,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Budget entity.
     *
     * @Route("/create", name="budget_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Budget:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Budget();
        $request = $this->getRequest();
        $form    = $this->createForm(new BudgetType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						//Affectation du budget aus écoles
						$ids = $request->request->get('ecoles');
						$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findBy(array('id' => $ids));
						foreach ($ecoles as $ecole)
						{
							$ecole_budget  = new EcoleBudget();
							$ecole_budget->setBudget($entity);
							$ecole_budget->setEcole($ecole);
							$em->persist($ecole_budget);
						}
						$em->flush();
            
            $this->get('session')->setFlash('notice', 'Budget a été créé avec succès');

            return $this->redirect($this->generateUrl('budget_show', array('id' => $entity->getId())));
            
        }
				$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findAll();

        return array(
            'entity' => $entity,
						'ecoles' => $ecoles,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Budget entity.
     *
     * @Route("/{id}/edit", name="budget_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Budget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budget entity.');
        }

        $editForm = $this->createForm(new BudgetType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
				$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findAll();
				$ids = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->getExistedEcoles($id);

        return array(
            'entity'      => $entity,
						'ecoles'      => $ecoles,
						'ids'         => $ids,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Budget entity.
     *
     * @Route("/{id}/update", name="budget_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Budget:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Budget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budget entity.');
        }

        $editForm   = $this->createForm(new BudgetType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
						//TODO move this code to the model
						//Affectation du budget aux écoles
						$ids = $request->request->get('ecoles');
						$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findBy(array('id' => $ids));
						$existed = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->getExistedEcoles($entity->getId());
						foreach ($ecoles as $ecole)
						{
							if ( !in_array($ecole->getId(), $existed) )
							{
								$ecole_budget  = new EcoleBudget();
								$ecole_budget->setBudget($entity);
								$ecole_budget->setEcole($ecole);
								$em->persist($ecole_budget);
							}
						}
						//Suppression de l'affactation du budget aux écoles
					  if ( !empty($ids) )
					  {
						  $entities = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->findByBudgetId( $entity->getId());
						  foreach ($entities as $entity)
						  {
							  if ( !in_array($entity->getEcoleId(), $ids) ) $em->remove($entity);
						  }
					  }
					  
						$em->flush();
            
            $this->get('session')->setFlash('notice', 'Budget a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('budget_show', array('id' => $id)));
        }

				$ecoles = $em->getRepository('AcmeFmpsBundle:Ecole')->findAll();
				$ids = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->getExistedEcoles($id);

        return array(
            'entity'      => $entity,
						'ecoles'      => $ecoles,
						'ids'         => $ids,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Budget entity.
     *
     * @Route("/{id}/delete", name="budget_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Budget')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Budget entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Budget a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('budget'));
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
			return $this->createFormBuilder(new Budget() )
	                 ->add('rubrique', 'entity', array('class' => 'AcmeFmpsBundle:Rubrique', 'label' => ' Rubrique', 'empty_value' => '--Sélectionnez--', 'required' => false))
	                ->add('annee', 'choice', array('choices' => FmpsLists::getDefaultYears(), 'label' => ' Année', 'empty_value' => '--Sélectionnez--', 'required' => false))
	                ->getForm();
		}
}
