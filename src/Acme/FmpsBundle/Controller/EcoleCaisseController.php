<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EcoleCaisse;
use Acme\FmpsBundle\Form\EcoleCaisseType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EcoleCaisse controller.
 *
 * @Route("/caisses")
 */
class EcoleCaisseController extends Controller
{
    /**
     * Lists all EcoleCaisse entities.
     *
     * @Route("/", name="ecolecaisse")
     * @Template()
     */
     public function indexAction()
	    {
	        $em = $this->getDoctrine()->getEntityManager();
	        $paginator = $this->get('knp_paginator');
	        $request = $this->getRequest();
	        $form = $this->getForm();
	        $csrf = $this->get('form.csrf_provider');
	        $repository = $em->getRepository('AcmeFmpsBundle:EcoleCaisse');
					$count = $repository->getCountByEcole();
				  $page = $this->get('request')->query->get('page', 1);
	        $form->bindRequest($request);
	        $user = $this->get('security.context')->getToken()->getUser();
	        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page, 15);

	        return $this->render('AcmeFmpsBundle:EcoleCaisse:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView(), 'csrf' => $csrf, 'count' =>$count ));

	    }

    /**
     * Finds and displays a EcoleCaisse entity.
     *
     * @Route("/{id}/show", name="ecolecaisse_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleCaisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

		/**
     * Validate EcoleCaisse entity.
     *
     * @Route("/validate", name="ecolecaisse_validate")
     * @Template()
     */
    public function validateAction()
    {
         $entity = new EcoleCaisse();
         $request = $this->getRequest();
         $numeroCompte = $request->query->get('numeroCompte');
         $entity->setEcoleId($request->query->get('ecoleId'));
         $entity->setNumeroCompte($request->query->get('numeroCompte'));
	       $form   = $this->createForm(new EcoleCaisseType(), $entity);
	
				if ($request->getMethod() == 'POST') {
					$entity  = new EcoleCaisse();
	        $request = $this->getRequest();
	        $em = $this->getDoctrine()->getEntityManager();
	        $ecole = $em->getRepository('AcmeFmpsBundle:Ecole')->find($request->request->get('ecoleId'));

	        $entity->setEcole($ecole);
	        $entity->setNumeroCompte($request->request->get('numeroCompte'));
	        
	        $em->persist($entity);
	        $em->flush();
				  $this->get('session')->setFlash('notice', 'Caisse a été créé avec succès');
	        return $this->redirect($this->generateUrl('ecolecaisse_show', array('id' => $entity->getId())));
	      }
	        
				else{
					$em = $this->getDoctrine()->getEntityManager();
	        $entities = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->findBy(array('numeroCompte' => $numeroCompte));

					 return array(
		            'entity' => $entity,
		            'entities' => $entities,
		            'form'   => $form->createView()
		        );
				}
	 
    }

    /**
     * Displays a form to create a new EcoleCaisse entity.
     *
     * @Route("/new", name="ecolecaisse_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EcoleCaisse();
        $ecoleId = $this->getRequest()->query->get('ecoleId');

				if ( !empty($ecoleId) ){
					$em = $this->getDoctrine()->getEntityManager();
	        $ecole = $em->getRepository('AcmeFmpsBundle:Ecole')->find($ecoleId);
	        $entity->setEcole($ecole);
				}
        
        $form   = $this->createForm(new EcoleCaisseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EcoleCaisse entity.
     *
     * @Route("/create", name="ecolecaisse_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleCaisse:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EcoleCaisse();
        $request = $this->getRequest();
        $form    = $this->createForm(new EcoleCaisseType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
				
						$caisse = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')
						             ->findOneByNumeroCompte($entity->getNumeroCompte());
						
						if ( $caisse == null or isset($_POST['validation']) ) {
              $em->flush();
            
						  $this->get('session')->setFlash('notice', 'Caisse a été créée avec succès');
              return $this->redirect($this->generateUrl('ecolecaisse_show', array('id' => $entity->getId())));
            }
						else{
							$this->get('session')->setFlash('notice', 'Ce compte est relié à d\'autre écoles ');
							return $this->redirect($this->generateUrl('ecolecaisse_validate', array('ecoleId' => $entity->getEcole()->getId(), 'numeroCompte' => $entity->getNumeroCompte())));
						}
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EcoleCaisse entity.
     *
     * @Route("/{id}/edit", name="ecolecaisse_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleCaisse entity.');
        }

        $editForm = $this->createForm(new EcoleCaisseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EcoleCaisse entity.
     *
     * @Route("/{id}/update", name="ecolecaisse_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleCaisse:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleCaisse entity.');
        }

        $editForm   = $this->createForm(new EcoleCaisseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
						$this->get('session')->setFlash('notice', 'Caisse a été modifiée avec succès');

            return $this->redirect($this->generateUrl('ecolecaisse_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EcoleCaisse entity.
     *
     * @Route("/{id}/delete", name="ecolecaisse_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
         $form = $this->createDeleteForm($id);
	       $request = $this->getRequest();

	       $form->bindRequest($request);
	        if ($form->isValid()) {
	            $em = $this->getDoctrine()->getEntityManager();
	            $entity = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->find($id);

	            if (!$entity) {
	                throw $this->createNotFoundException('Unable to find Classe entity.');
	            }

	            $em->remove($entity);
	            $em->flush();
	        }
	
	        if($request->isXmlHttpRequest())
	        {
							$em = $this->getDoctrine()->getEntityManager();
	            $entity = $em->getRepository('AcmeFmpsBundle:EcoleCaisse')->find($id);
	            $csrf  = $this->container->get('form.csrf_provider');
	            $token = $request->query->get('token');
	            if ( $csrf->isCsrfTokenValid($entity->getCsrfIntention('delete'), $token) ){
		
								if (!$entity) {
		                throw $this->createNotFoundException('Unable to find Classe entity.');
		            }

		            $em->remove($entity);
		            $em->flush();
		
		            $response = array('success'=> 1);
            	}
              else{
	              $response = array('success'=> 0);
              }
	
	            $response = new Response(json_encode(array(	$response )));
	            $response->headers->set('Content-Type', 'application/json');
	            return $response;
	        }
	        else 
	        {
							$this->get('session')->setFlash('notice', 'Caisse a été supprimée avec succès');
	            return $this->redirect($this->generateUrl('ecolecaisse'));
	        }
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
		
			$form = $this->createFormBuilder(new EcoleCaisse() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
	                ->add('numeroCompte', 'text', array('label' => 'Numéro du compte', 'required' => false, 'attr' => array('placeholder' => 'Numéro du compte')))
	                ->getForm();
				return $form;
		}
		
}
