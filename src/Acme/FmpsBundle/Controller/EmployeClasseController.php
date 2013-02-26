<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EmployeClasse;
use Acme\FmpsBundle\Form\EmployeClasseType;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EmployeClasse controller.
 *
 * @Route("/employe_classes")
 */
class EmployeClasseController extends Controller
{
    /**
     * Lists all EmployeClasse entities.
     *
     * @Route("/", name="employeclasse")
     * @Template()
     */
    public function indexAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
	       $paginator = $this->get('knp_paginator');
	       $request = $this->getRequest();
	       $form = $this->getForm();

	       $form->bindRequest($request);
	       $repository = $em->getRepository('AcmeFmpsBundle:EmployeClasse');
				 $user = $this->get('security.context')->getToken()->getUser();
	       $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $this->get('request')->query->get('page', 1),15);

	        return $this->render('AcmeFmpsBundle:EmployeClasse:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a EmployeClasse entity.
     *
     * @Route("/{id}/show", name="employeclasse_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeClasse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EmployeClasse entity.
     *
     * @Route("/new", name="employeclasse_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EmployeClasse();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EmployeClasseType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EmployeClasse entity.
     *
     * @Route("/create", name="employeclasse_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeClasse:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EmployeClasse();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EmployeClasseType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

						$count = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->getCount($entity);
						
						if ( $count > 0 ){
							$this->get('session')->setFlash('error', 'Employe est déjà affecté dans cette classe');
							return $this->redirect($this->generateUrl('employeclasse'));
						}
						
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Affectation a été créé avec succès');
						
            return $this->redirect($this->generateUrl('employeclasse_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EmployeClasse entity.
     *
     * @Route("/{id}/edit", name="employeclasse_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeClasse entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EmployeClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EmployeClasse entity.
     *
     * @Route("/{id}/update", name="employeclasse_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeClasse:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeClasse entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EmployeClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
	
					$count = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->getCount($entity);
					
					if ( $count > 1 ){
						$this->get('session')->setFlash('error', 'Employe est déjà affecté dans cette classe');
						return $this->redirect($this->generateUrl('employeclasse'));
					}
					
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Affectation a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('employeclasse_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EmployeClasse entity.
     *
     * @Route("/{id}/delete", name="employeclasse_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmployeClasse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->setFlash('notice', 'Affectation a été supprimée avec succès');
        return $this->redirect($this->generateUrl('employeclasse'));
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
			$user = $this->get('security.context')->getToken()->getUser();
			$employes = $user->getEmployes();
	    if ( !empty($employes) )
	    {
	       $where = 'e.id IN (' . implode(', ', $employes) . ')';
	    }
	    else{
	       $where = 'e.id > 1';
	    }
			$form = $this->createFormBuilder(new EmployeClasse() )
	                ->add('employe', 'entity', array('class' => 'AcmeFmpsBundle:Employe', 'label' => 'Employé', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where)
																		->orderBy('e.prenom', 'ASC');
		                     }
		                     ))
								  ->add('anneeScolaire', 'entity', array('required' => false, 'class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--', 
								              'query_builder' => function (EntityRepository $er) 
								                   {
								                       return $er->createQueryBuilder('a')
								                              ->orderBy('a.libelleAnneeScolaire', 'DESC');
								                   }
								                   ))					
	                
	                ->getForm();
				return $form;
		}
}
