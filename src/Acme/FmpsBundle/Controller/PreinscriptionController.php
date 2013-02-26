<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Preinscription;
use Acme\FmpsBundle\Form\PreinscriptionType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Preinscription controller.
 *
 * @Route("/preinscription")
 */
class PreinscriptionController extends Controller
{
    /**
     * Lists all Preinscription entities.
     *
     * @Route("/", name="preinscription")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	      $paginator = $this->get('knp_paginator');
	      $request = $this->getRequest();
			  $form = $this->createSearchForm();
			  $page = $request->query->get('page', 1);

	      $form->bindRequest($request);
	      $repository = $em->getRepository('AcmeFmpsBundle:Preinscription');
	      $user = $this->get('security.context')->getToken()->getUser();
	      $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page,15);

	      return $this->render('AcmeFmpsBundle:Preinscription:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Preinscription entity.
     *
     * @Route("/{id}/show", name="preinscription_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Preinscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preinscription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Preinscription entity.
     *
     * @Route("/new", name="preinscription_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Preinscription();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new PreinscriptionType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Preinscription entity.
     *
     * @Route("/create", name="preinscription_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Preinscription:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Preinscription();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new PreinscriptionType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Préinscription a été ajouté avec succès');

            return $this->redirect($this->generateUrl('preinscription_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Preinscription entity.
     *
     * @Route("/{id}/edit", name="preinscription_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Preinscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preinscription entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new PreinscriptionType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Preinscription entity.
     *
     * @Route("/{id}/update", name="preinscription_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Preinscription:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Preinscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preinscription entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new PreinscriptionType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Préinscription a été modifiée avec succès');

            return $this->redirect($this->generateUrl('preinscription_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Preinscription entity.
     *
     * @Route("/{id}/delete", name="preinscription_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Preinscription')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Preinscription entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Préinscription a été supprimée avec succès');
        }

        return $this->redirect($this->generateUrl('preinscription'));
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
		  }
		  else{
		     $where = 'e.id > 1';
		  }
			$form = $this->createFormBuilder(new Preinscription() )
	              ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
				 'required' => false, 
	                'query_builder' => function (EntityRepository $er) use ($where)
	                     {
	                         return $er->createQueryBuilder('e')
	                                ->where($where);
	                     }
	                     ))
						    ->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--', 'required' => false))
						    ->add('section', 'entity', array('class' => 'AcmeFmpsBundle:Section', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--', 'required' => false))
						    ->add('category', 'entity', array('class' => 'AcmeFmpsBundle:Category', 'label' => 'Catégorie', 'empty_value' => '--Sélectionnez--', 'required' => false))
						    ->add('nomEnfant' ,'text' , array('required' => false, 'label' => 'Nom enfant', 'attr' => array('placeholder' => 'Enfant')))
						    ->add('nomTiteur' ,'text' , array('required' => false, 'label' => 'Nom tuteur', 'attr' => array('placeholder' => 'Tuteur')))
								->getForm();
	        return $form;
		}
}
