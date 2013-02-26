<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\OffreService;
use Acme\FmpsBundle\Form\OffreServiceType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * OffreService controller.
 *
 * @Route("/offres_service")
 */
class OffreServiceController extends Controller
{
    /**
     * Lists all OffreService entities.
     *
     * @Route("/", name="offreservice")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
		    $form = $this->createSearchForm();
	    	$page = $this->get('request')->query->get('page', 1);

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:OffreService');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page,15);
        
        return $this->render('AcmeFmpsBundle:OffreService:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a OffreService entity.
     *
     * @Route("/{id}/show", name="offreservice_show")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:OffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OffreService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new OffreService entity.
     *
     * @Route("/new", name="offreservice_new")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function newAction()
    {
        $entity = new OffreService();
        $form   = $this->createForm(new OffreServiceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new OffreService entity.
     *
     * @Route("/create", name="offreservice_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:OffreService:new.html.twig")
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function createAction()
    {
        $entity  = new OffreService();
        $request = $this->getRequest();
        $form    = $this->createForm(new OffreServiceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Offre de service a été créé avec succès');

            return $this->redirect($this->generateUrl('offreservice_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing OffreService entity.
     *
     * @Route("/{id}/edit", name="offreservice_edit")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:OffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OffreService entity.');
        }

        $editForm = $this->createForm(new OffreServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing OffreService entity.
     *
     * @Route("/{id}/update", name="offreservice_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:OffreService:edit.html.twig")
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:OffreService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OffreService entity.');
        }

        $editForm   = $this->createForm(new OffreServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Offre de service a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('offreservice_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a OffreService entity.
     *
     * @Route("/{id}/delete", name="offreservice_delete")
     * @Method("post")
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:OffreService')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OffreService entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Offre de service a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('offreservice'));
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
			$form = $this->createFormBuilder(new OffreService() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
									->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'required' => false, 'empty_value' => '--Sélectionnez--', 'label' => 'Année scolaire'))
									->add('service', 'entity', array('class' => 'AcmeFmpsBundle:Service', 'required' => false, 'empty_value' => '--Sélectionnez--'))
	                ->getForm();
	        return $form;
		}
}
