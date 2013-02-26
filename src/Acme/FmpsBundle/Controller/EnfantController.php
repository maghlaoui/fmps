<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Enfant;
use Acme\FmpsBundle\Form\EnfantType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Doctrine\ORM\EntityRepository;

/**
 * Enfant controller.
 *
 * @Route("/enfants")
 */
class EnfantController extends Controller
{
    /**
     * Lists all Enfant entities.
     *
     * @Route("/", name="enfant")
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
        $repository = $em->getRepository('AcmeFmpsBundle:Enfant');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page,15);
       
        return $this->render('AcmeFmpsBundle:Enfant:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Enfant entity.
     *
     * @Route("/{id}/show", name="enfant_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Enfant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enfant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Enfant entity.
     *
     * @Route("/new", name="enfant_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Enfant();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new EnfantType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Enfant entity.
     *
     * @Route("/create", name="enfant_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Enfant:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Enfant();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new EnfantType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
						$entity->setEcole($user->getEmploye()->getEcole());
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Enfant a été créé avec succès');
	          return $this->redirect($this->generateUrl('enfant_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Enfant entity.
     *
     * @Route("/{id}/edit", name="enfant_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Enfant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enfant entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm = $this->createForm(new EnfantType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Enfant entity.
     *
     * @Route("/{id}/update", name="enfant_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Enfant:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Enfant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enfant entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new EnfantType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
			$this->get('session')->setFlash('notice', 'Enfant a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('enfant_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Enfant entity.
     *
     * @Route("/{id}/delete", name="enfant_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Enfant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Enfant entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Enfant a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('enfant'));
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
			$form = $this->createFormBuilder(new Enfant() )
									->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
	                ->add('nom', 'text', array('label' => 'Nom', 'required' => false, 'attr' => array('placeholder' => 'Nom')))
	                ->add('prenom', 'text', array('label' => 'Adresse', 'required' => false, 'attr' => array('placeholder' => 'Prénom')))
									->add('sexe', 'choice', array('choices' => array(0 => 'Masculin', 1 => 'Féminin'), 'required' => false, 'empty_value' => '--Sélectionnez--'))                
									->add('dateNaissance', 'date', array('label' => "Date de naissance", 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date')))
	                ->getForm();
	        return $form;
		}
		
		protected function _getErrors($form)
		{
		    // Validate form
		    $errors = $this->get('validator')->validate($form);

		    // Prepare collection
		    $collection = array();

		    // Loop through each element of the form
		    foreach ($form->getChildren() as $key => $child) {
		        $collection[$key] = "";
		    }
				$translator = $this->get('translator');
		    foreach ($errors as $error) {
		        $collection[str_replace("data.", "", $error->getPropertyPath())] = $translator->trans($error->getMessage());
		    }
		    return $collection;
		}
		
		public function renderJson($options)
	  {
			$response = new Response(json_encode($options));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
		}
}
