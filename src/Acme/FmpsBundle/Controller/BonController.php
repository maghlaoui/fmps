<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Bon;
use Acme\FmpsBundle\Form\BonType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Bon controller.
 *
 * @Route("/bons")
 */
class BonController extends Controller
{
    /**
     * Lists all Bon entities.
     *
     * @Route("/", name="bon")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $paginator = $this->get('knp_paginator');
				$form = $this->getSearchForm();
        $request = $this->getRequest();
        $form->bindRequest($request);
        $page = $request->query->get('page', 1);        
        $repository = $em->getRepository('AcmeFmpsBundle:Bon');
				$user = $this->get('security.context')->getToken()->getUser();

        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page, 15);

        return $this->render('AcmeFmpsBundle:Bon:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
    }

    /**
     * Finds and displays a Bon entity.
     *
     * @Route("/{id}/show", name="bon_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Bon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Bon entity.
     *
     * @Route("/new", name="bon_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bon();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new BonType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Bon entity.
     *
     * @Route("/create", name="bon_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Bon:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Bon();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new BonType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Bon a été créé avec succès');

            return $this->redirect($this->generateUrl('bon_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Bon entity.
     *
     * @Route("/{id}/edit", name="bon_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Bon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bon entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new BonType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Bon entity.
     *
     * @Route("/{id}/update", name="bon_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Bon:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Bon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bon entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new BonType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Bon a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('bon_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Bon entity.
     *
     * @Route("/{id}/delete", name="bon_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Bon')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bon entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Bon a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('bon'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    private function getSearchForm() {
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
        $form = $this->createFormBuilder(new Bon())
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
                ->add('fournisseur', 'text', array('required' => false, 'attr' => array('placeholder' => 'Fournisseur')))
                ->add('patente', 'text', array('required' => false, 'attr' => array('placeholder' => 'Patente')))
                ->getForm();

        return $form;
    }

}
