<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EcoleBudget;
use Acme\FmpsBundle\Form\EcoleBudgetType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EcoleBudget controller.
 *
 * @Route("/ecole_budgets")
 */
class EcoleBudgetController extends Controller
{
    /**
     * Lists all EcoleBudget entities.
     *
     * @Route("/", name="ecolebudget")
     * @Template()
     */
    public function indexAction()
    {

			$em = $this->getDoctrine()->getEntityManager();
  		$paginator = $this->get('knp_paginator');
  		$request = $this->getRequest();
  		$form = $this->createSearchForm();
  
    	$form->bindRequest($request);
    	$repository = $em->getRepository('AcmeFmpsBundle:EcoleBudget');
      $user = $this->get('security.context')->getToken()->getUser();
    	$entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user),
 			$request->query->get('page', 1),15);
  
  		return $this->render('AcmeFmpsBundle:EcoleBudget:index.html.twig', array( 'entities' => $entities,
 			'form' => $form->createView() ));
    }

    /**
     * Finds and displays a EcoleBudget entity.
     *
     * @Route("/{id}/show", name="ecolebudget_show")
     * @Template()
     * @Secure(roles="ROLE_DC")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleBudget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EcoleBudget entity.
     *
     * @Route("/new", name="ecolebudget_new")
     * @Template()
     * @Secure(roles="ROLE_DC")
     */
    public function newAction()
    {
        $entity = new EcoleBudget();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EcoleBudgetType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EcoleBudget entity.
     *
     * @Route("/create", name="ecolebudget_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleBudget:new.html.twig")
     * @Secure(roles="ROLE_DC")
     */
    public function createAction()
    {
        $entity  = new EcoleBudget();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EcoleBudgetType(), $entity, array('user' => $user));

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Budget a été créé avec succès');
            return $this->redirect($this->generateUrl('ecolebudget_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EcoleBudget entity.
     *
     * @Route("/{id}/edit", name="ecolebudget_edit")
     * @Template()
     * @Secure(roles="ROLE_DC")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleBudget entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EcoleBudgetType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EcoleBudget entity.
     *
     * @Route("/{id}/update", name="ecolebudget_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleBudget:edit.html.twig")
     * @Secure(roles="ROLE_DC")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleBudget entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EcoleBudgetType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Budget a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('ecolebudget_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EcoleBudget entity.
     *
     * @Route("/{id}/delete", name="ecolebudget_delete")
     * @Method("post")
     * @Secure(roles="ROLE_DC")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EcoleBudget')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EcoleBudget entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

				$this->get('session')->setFlash('notice', 'Budget a été supprimé avec succès');
        return $this->redirect($this->generateUrl('ecolebudget'));
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
			$schools = implode(', ', $ecoles) ;
		  if ( !empty($ecoles) && !in_array(1, $ecoles) )
		  {
		     $where = 'e.id IN (' . $schools . ')';
		  }
		  else{
		     $where = 'e.id > 1';
		  }
		
			$form = $this->createFormBuilder(new EcoleBudget() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
									->add('budget', 'entity', array('class' => 'AcmeFmpsBundle:Budget', 'label' => 'Rubrique', 'empty_value' => '--Sélectionnez--',	'required' => false, 
							                'query_builder' => function (EntityRepository $er) use ($schools)
							                     {
							                         return $er->createQueryBuilder('b')
							                                ->where("b.id IN (SELECT eb.budgetId FROM AcmeFmpsBundle:EcoleBudget eb WHERE  eb.ecoleId in ($schools) )");

							                     }
							                     ))
								
	                ->getForm();
				return $form;
		}
}
