<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Partenaire;
use Acme\FmpsBundle\Form\PartenaireType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * Partenaire controller.
 *
 * @Route("/partenaires")
 */
class PartenaireController extends Controller
{
    /**
     * Lists all Partenaire entities.
     *
     * @Route("/", name="partenaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT p FROM AcmeFmpsBundle:Partenaire p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $form = $this->getSearchForm();
        $request = $this->getRequest();
			  $current_page = $this->get('request')->query->get('page', 1);
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Partenaire');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $current_page, 15);
       
        return $this->render('AcmeFmpsBundle:Partenaire:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Partenaire entity.
     *
     * @Route("/{id}/show", name="partenaire_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenaire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Partenaire entity.
     *
     * @Route("/new", name="partenaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Partenaire();
        $form   = $this->createForm(new PartenaireType(), $entity);
		    $back_url = $this->getRequest()->query->get('back_url');
        $this->get('session')->set('back_url', $back_url);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Partenaire entity.
     *
     * @Route("/create", name="partenaire_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Partenaire:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Partenaire();
        $request = $this->getRequest();
        $form    = $this->createForm(new PartenaireType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

						if ($request->isXmlHttpRequest()) {
							$data = array('success' => 1, 'dom_id' => 'partenariat_partenaire_partenaire', 'notice' => 'Partenaire a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getNomPartenaire());
							return $this->renderJson($data);
						}
						else {
							$this->get('session')->setFlash('notice', 'Partenaire a été créé avec succès');
							//return $this->redirect($this->generateUrl('partenaire_show', $entity->getId()));
							return $this->redirect($this->generateUrl('partenaire'));
						}	

	        }
	        else {
							if ($request->isXmlHttpRequest()) {
								return $this->renderJson( array('success' => 0, 'notice' => 'Veuillez vérifier le formulaire') );
							}
							else {
								return array(
			            'entity' => $entity,
			            'form'   => $form->createView()
			          );
							}

					}
        
    }

    /**
     * Displays a form to edit an existing Partenaire entity.
     *
     * @Route("/{id}/edit", name="partenaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenaire')->find($id);

				$request = $this->getRequest();
        $this->get('session')->set('partenariat_id', $request->query->get('partenariat_id'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenaire entity.');
        }

        $editForm = $this->createForm(new PartenaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Partenaire entity.
     *
     * @Route("/{id}/update", name="partenaire_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Partenaire:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Partenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenaire entity.');
        }

        $editForm   = $this->createForm(new PartenaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
				
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
	
            $em->persist($entity);
					
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Partenaire a été mis à jour avec succès');

            //return $this->redirect($this->generateUrl('partenaire_show', $id));
						return $this->redirect($this->generateUrl('partenaire'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Partenaire entity.
     *
     * @Route("/{id}/delete", name="partenaire_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Partenaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partenaire entity.');
            }
            

            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Partenaire a été supprimé avec succès');
             
        }

        return $this->redirect($this->generateUrl('partenaire'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
	
	private function getSearchForm()
	{
		$form = $this->createFormBuilder(new Partenaire() )
                ->add('nomPartenaire', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Nom', 'class' => 'span2'), 'required' => false))
                ->add('adressePartenaire', 'text', array('label' => 'Adresse', 'attr' => array('placeholder' => 'Adresse', 'class' => 'span2'), 'required' => false))
                ->add('tel1Partenaire', 'text', array('label' => 'Téléphone', 'attr' => array('placeholder' => 'Téléphone', 'class' => 'span2'), 'required' => false))
                ->add('faxPartenaire', 'text', array('label' => 'Fax', 'attr' => array('placeholder' => 'Fax'), 'required' => false))
                ->add('mailPartenaire', 'text', array('label' => 'Email', 'attr' => array('placeholder' => 'Email'), 'required' => false))
                ->add('ville', 'entity', array('class' => 'AcmeFmpsBundle:Ville', 'empty_value' => 'Sélectionnez une ville', 
				'required' => false))
                ->getForm();
	    return $form;
	}
	
	private function renderJson($options){
			$response = new Response(json_encode($options));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
	}
	
}
