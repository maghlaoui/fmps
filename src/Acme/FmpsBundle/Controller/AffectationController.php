<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Affectation;
use Acme\FmpsBundle\Form\AffectationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Affectation controller.
 *
 * @Route("/affectations")
 */
class AffectationController extends Controller
{
    /**
     * Lists all Affectation entities.
     *
     * @Route("/", name="affectation")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH, ROLE_DIRECTEUR")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$repository = $em->getRepository('AcmeFmpsBundle:Affectation');
				$form = $this->getForm();
				$request = $this->getRequest();
				$paginator = $this->get('knp_paginator');
				$page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page,15);
        
        return $this->render('AcmeFmpsBundle:Affectation:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Affectation entity.
     *
     * @Route("/{id}/show", name="affectation_show")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH, ROLE_DIRECTEUR")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Affectation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affectation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Affectation entity.
     *
     * @Route("/new", name="affectation_new")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function newAction()
    {
        $entity = new Affectation();
        
				$employeId = $this->getRequest()->query->get('employe_id');
				$this->get('session')->set('employeId', $employeId);

				if ( !empty($employeId) ){
					$em = $this->getDoctrine()->getEntityManager();
					$employe = $em->getRepository('AcmeFmpsBundle:Employe')->find($employeId);
					$entity->setEmploye($employe);
				}
				
        $form   = $this->createForm(new AffectationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Affectation entity.
     *
     * @Route("/create", name="affectation_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Affectation:new.html.twig")
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function createAction()
    {
        $entity  = new Affectation();
        $request = $this->getRequest();
        $form    = $this->createForm(new AffectationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);

						$employe = $entity->getEmploye();
				    $affectation = $employe->getRecentAffectation();
				    $employeId = $this->get('session')->get('employeId');
				
						if ( $affectation ){
						  $employe->setEcole($affectation->getEcole());
					    $em->persist($employe);
					  }
						
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Affectation a été créée avec succès');

						if ( empty( $employeId ) ){
							
							return $this->redirect($this->generateUrl('affectation_show', array('id' => $entity->getId())));
						}
						else{
							$this->get('session')->set('employeId', null);
							
							return $this->redirect($this->generateUrl('employe_show', array('id' => $employeId)));
						} 
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Affectation entity.
     *
     * @Route("/{id}/edit", name="affectation_edit")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Affectation')->find($id);

				$return = $this->getRequest()->query->get('return');
        $this->get('session')->set('return', $return);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affectation entity.');
        }

        $editForm = $this->createForm(new AffectationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Affectation entity.
     *
     * @Route("/{id}/update", name="affectation_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Affectation:edit.html.twig")
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Affectation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affectation entity.');
        }

        $editForm   = $this->createForm(new AffectationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);

						$employe = $entity->getEmploye();
				    $affectation = $employe->getRecentAffectation();
				
						if ( $affectation ){
						  $employe->setEcole($affectation->getEcole());
					    $em->persist($employe);
					  }
						
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Affectation a été mise à jour avec succès');

		        $return = $this->get('session')->get('return');
		        if ( !empty( $return )){
			        $this->get('session')->set('return', null);
			        return $this->redirect($this->generateUrl('employe_show', array('id' => $entity->getEmployeId())));
		        }
           
            return $this->redirect($this->generateUrl('affectation_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Affectation entity.
     *
     * @Route("/{id}/delete", name="affectation_delete")
     * @Method("post")
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Affectation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Affectation entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Affectation a été supprimée avec succès');
        }
        
        return $this->redirect($this->generateUrl('affectation'));
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
		$ecoles = $user->getEcoles();
    if ( !empty($ecoles) && !in_array(1, $ecoles) )
    {
       $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
    }
    else{
       $where = 'e.id > 1';
    }
		$form = $this->createFormBuilder(new Affectation() )
                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
				 'required' => false, 
	                'query_builder' => function (EntityRepository $er) use ($where)
	                     {
	                         return $er->createQueryBuilder('e')
	                                ->where($where);
	                     }
	                     ))
                ->add('dateDebutAffectation', 'date', array('label' => "Date de début", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
                ->add('dateFinAffectation', 'date', array('label' => "Date de fin", 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
                
                ->getForm();

        return $form;
	}
}
