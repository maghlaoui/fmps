<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Decharge;
use Acme\FmpsBundle\Form\DechargeType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Decharge controller.
 *
 * @Route("/decharges")
 */
class DechargeController extends Controller
{
    /**
     * Lists all Decharge entities.
     *
     * @Route("/", name="decharge")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
		    $form = $this->createSearchForm();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Decharge');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $this->get('request')->query->get('page', 1), 50);
        
        return $this->render('AcmeFmpsBundle:Decharge:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Decharge entity.
     *
     * @Route("/{id}/show", name="decharge_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Decharge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Decharge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Decharge entity.
     *
     * @Route("/new", name="decharge_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Decharge();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new DechargeType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Decharge entity.
     *
     * @Route("/create", name="decharge_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Decharge:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Decharge();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new DechargeType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
           $em = $this->getDoctrine()->getEntityManager();
           $em->persist($entity);
           $em->flush();

		       $this->get('session')->setFlash('notice', 'Décharge a été créée avec succès');
		
					 return $this->redirect($this->generateUrl('decharge_show', array('id' => $entity->getId())));
        }

				else {
					
						return array(
	            'entity' => $entity,
	            'form'   => $form->createView()
	          );
				}

    }

    /**
     * Displays a form to edit an existing Decharge entity.
     *
     * @Route("/{id}/edit", name="decharge_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Decharge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Decharge entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new DechargeType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Decharge entity.
     *
     * @Route("/{id}/update", name="decharge_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Decharge:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Decharge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Decharge entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new DechargeType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Décharge a été mise à jour avec succès');

            return $this->redirect($this->generateUrl('decharge_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Decharge entity.
     *
     * @Route("/{id}/delete", name="decharge_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Decharge')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Decharge entity.');
            }

					  $em->remove($entity);
	          $em->flush();
	
					  $this->get('session')->setFlash('notice', 'Décharge a été supprimée avec succès');
        }
        
        return $this->redirect($this->generateUrl('decharge'));    
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

		private function createSearchForm() {
			
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
		
		    $form = $this->createFormBuilder(new Decharge())
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
		            ->add('nom', 'text', array('required' => false, 'attr' => array('placeholder' => 'Nom')))
		            ->add('prenom', 'text', array('label' => 'Prénom', 'required' => false, 'attr' => array('placeholder' => 'Prénom')))
		            ->add('cin', 'text', array('required' => false, 'attr' => array('placeholder' => 'Cin')))
		            ->getForm();
		    return $form;
		}

}
