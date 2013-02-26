<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\TypeContribution;
use Acme\FmpsBundle\Form\TypeContributionType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * TypeContribution controller.
 *
 * @Route("/periodicites")
 */
class TypeContributionController extends Controller
{
    /**
     * Lists all TypeContribution entities.
     *
     * @Route("/", name="typecontribution")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql = "SELECT t FROM AcmeFmpsBundle:TypeContribution t";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1),15);

        return $this->render('AcmeFmpsBundle:TypeContribution:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a TypeContribution entity.
     *
     * @Route("/{id}/show", name="typecontribution_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeContribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeContribution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TypeContribution entity.
     *
     * @Route("/new", name="typecontribution_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TypeContribution();
        $form   = $this->createForm(new TypeContributionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TypeContribution entity.
     *
     * @Route("/create", name="typecontribution_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeContribution:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TypeContribution();
        $request = $this->getRequest();
        $form    = $this->createForm(new TypeContributionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getEntityManager();
          $em->persist($entity);
          $em->flush();

					//$referer = $request->headers->get('referer');
					//return $this->redirect($referer);
         
					if ($request->isXmlHttpRequest()) {
						$data = array('success' => 1, 'dom_id' => 'partenariat_partenaire_type_contribution', 'notice' => 'Périodicité a été créé avec succès', 'id' => $entity->getId(), 'label' => $entity->getLibelleTypeContribution());
						return $this->renderJson($data);
					}
					else {
						$this->get('session')->setFlash('notice', 'Périodicité a été créé avec succès');
						return $this->redirect($this->generateUrl('typecontribution_show', $entity->getId()));
					}	
					
        }
        else {
						if ($request->isXmlHttpRequest()) {
							//$html = $this->renderView('AcmeFmpsBundle:TypeContribution:form.html.twig', array('entity' => $entity, 'form'   => $form->createView()));
							return $this->renderJson( array('success' => 0, 'html' => $html, 'notice' => 'Veuillez vérifier le formulaire') );
						}
						else {
							return array(
		            'entity' => $entity,
		            'form'   => $form->createView(),
		          );
						}
					  
				}
				
    }

    /**
     * Displays a form to edit an existing TypeContribution entity.
     *
     * @Route("/{id}/edit", name="typecontribution_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeContribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeContribution entity.');
        }

        $editForm = $this->createForm(new TypeContributionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TypeContribution entity.
     *
     * @Route("/{id}/update", name="typecontribution_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:TypeContribution:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:TypeContribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeContribution entity.');
        }

        $editForm   = $this->createForm(new TypeContributionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Périodicité a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('typecontribution_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TypeContribution entity.
     *
     * @Route("/{id}/delete", name="typecontribution_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:TypeContribution')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeContribution entity.');
            }

						$em->remove($entity);
	          $em->flush();
							
					  $this->get('session')->setFlash('notice', 'Périodicité a été supprimé avec succès');
        }
        		
        return $this->redirect($this->generateUrl('typecontribution'));  
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
		
		private function renderJson($options){
				$response = new Response(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
		}

}
