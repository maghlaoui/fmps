<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Ecole;
use Acme\FmpsBundle\Form\EcoleType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Ecole controller.
 *
 * @Route("/ecoles")
 */
class EcoleController extends Controller
{
    /**
     * Lists all Ecole entities.
     *
     * @Route("/", name="ecole")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
		    $form = $this->createSearchForm();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Ecole');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $this->get('request')->query->get('page', 1), 50);

       if ( count($entities) == 1 )
			 {
					return $this->redirect($this->generateUrl('ecole_show', array('id' => $user->getEmploye()->getEcoleId())));
					exit;
			 }
        
        return $this->render('AcmeFmpsBundle:Ecole:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a Ecole entity.
     *
     * @Route("/{id}/show", name="ecole_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);
				
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ecole entity.');
        }

				$affectations = $em->getRepository('AcmeFmpsBundle:Affectation')->getCurrentAffectations($id);
        $inscriptions = $entity->getInscriptions();
				$offres_service = $entity->getOffresServices();

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        		'affectations'=> $affectations,
						'offres_service'=> $offres_service);
    }

    /**
     * Displays a form to create a new Ecole entity.
     *
     * @Route("/new", name="ecole_new")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function newAction()
    {
        $entity = new Ecole();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EcoleType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Ecole entity.
     *
     * @Route("/create", name="ecole_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Ecole:new.html.twig")
		 * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function createAction()
    {
        $entity  = new Ecole();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EcoleType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Ecole a été créé avec succès');

            return $this->redirect($this->generateUrl('ecole_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Ecole entity.
     *
     * @Route("/{id}/edit", name="ecole_edit")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DIRECTEUR")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ecole entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EcoleType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Ecole entity.
     *
     * @Route("/{id}/update", name="ecole_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Ecole:edit.html.twig")
		 * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DIRECTEUR")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ecole entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EcoleType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Ecole a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('ecole_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ecole entity.
     *
     * @Route("/{id}/delete", name="ecole_delete")
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
            $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ecole entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        if($request->isXmlHttpRequest())
        {
            $response = new Response(json_encode(array(	'success'=> 1,)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        else 
        {
            return $this->redirect($this->generateUrl('ecole'));
        }
        
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
		$form = $this->createFormBuilder(new Ecole() )
                ->add('nom', 'text', array('label' => 'Nom', 'required' => false, 'attr' => array('placeholder' => 'Nom', 'class' => 'span2')))
                ->add('adresse', 'text', array('label' => 'Adresse', 'required' => false, 'attr' => array('placeholder' => 'Adresse', 'class' => 'span2')))
                ->add('dateOuverture', 'date', array('label' => "Date d'ouverture", 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date span2', 'placeholder' => "Date d'ouverture")))
                ->add('ville', 'entity', array('class' => 'AcmeFmpsBundle:Ville', 'label' => 'Ville', 'empty_value' => '--Sélectionnez--',	'required' => false, 
			              'query_builder' => function (EntityRepository $er) 
			                   {
			                       return $er->createQueryBuilder('v')
			                              ->where('v.id IN (SELECT e.villeId FROM AcmeFmpsBundle:Ecole e)');
			                   }
			                   ))
                ->add('reseau_prescolaire', 'entity', array('class' => 'AcmeFmpsBundle:ReseauPrescolaire', 'label' => 'Réseau préscolaire', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->getForm();
        return $form;
	}
}
