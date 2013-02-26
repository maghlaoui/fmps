<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EcoleAchat;
use Acme\FmpsBundle\Form\EcoleAchatType;
use Doctrine\ORM\EntityRepository;
use Acme\FmpsBundle\Util\FmpsLists;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * EcoleAchat controller.
 *
 * @Route("/achats")
 */
class EcoleAchatController extends Controller
{
    /**
     * Lists all EcoleAchat entities.
     *
     * @Route("/", name="ecoleachat")
     * @Template()
     */
    public function indexAction()
    {
				$em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->createSearchForm();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:EcoleAchat');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $request->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:EcoleAchat:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a EcoleAchat entity.
     *
     * @Route("/{id}/show", name="ecoleachat_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleAchat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleAchat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EcoleAchat entity.
     *
     * @Route("/new", name="ecoleachat_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EcoleAchat();
				$entity->setEtatFacture('engagé');
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EcoleAchatType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EcoleAchat entity.
     *
     * @Route("/create", name="ecoleachat_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleAchat:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EcoleAchat();
        $user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EcoleAchatType(), $entity, array('user' => $user));
				$request = $this->getRequest();
				
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Facture a été créée avec succès');
            return $this->redirect($this->generateUrl('ecoleachat_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EcoleAchat entity.
     *
     * @Route("/{id}/edit", name="ecoleachat_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleAchat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleAchat entity.');
        }
        
				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EcoleAchatType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EcoleAchat entity.
     *
     * @Route("/{id}/update", name="ecoleachat_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleAchat:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleAchat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleAchat entity.');
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EcoleAchatType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Facture a été mise à jour avec succès');
            return $this->redirect($this->generateUrl('ecoleachat_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EcoleAchat entity.
     *
     * @Route("/{id}/delete", name="ecoleachat_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EcoleAchat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EcoleAchat entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

				$this->get('session')->setFlash('notice', 'Facture a été supprimée avec succès');
        return $this->redirect($this->generateUrl('ecoleachat'));
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
		
			$form = $this->createFormBuilder(new EcoleAchat() )
									->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
									 ->add('fournisseur')
									 ->add('budget', 'entity', array('class' => 'AcmeFmpsBundle:Budget', 'label' => 'Budget', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where1)
		                     {
		                         return $er->createQueryBuilder('b')
		                                ->where($where1);
		                     }
		                     ))
	                 ->add('modePayement', 'choice', array('label' => 'Mode de règlement', 'choices' => FmpsLists::getDefaultPaymentTypes(), 'empty_value' => '--Sélectionnez--',	'required' => false))
									 ->add('etatFacture', 'choice', array('label' => 'Etat de facture', 'choices' => FmpsLists::getDefaultOrderStatus(), 'empty_value' => '--Sélectionnez--',	'required' => false))
	                ->getForm();
				return $form;
		}
}
