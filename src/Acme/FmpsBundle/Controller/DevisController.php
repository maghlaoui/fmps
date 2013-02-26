<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Devis;
use Acme\FmpsBundle\Form\DevisType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Devis controller.
 *
 * @Route("/devis")
 */
class DevisController extends Controller
{
    /**
     * Lists all Devis entities.
     *
     * @Route("/", name="devis")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        
        $form = $this->getForm();
        
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Devis');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $this->get('request')->query->get('page', 1),15);
        

        return $this->render('AcmeFmpsBundle:Devis:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Devis entity.
     *
     * @Route("/{id}/show", name="devis_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Devis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Devis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Devis entity.
     *
     * @Route("/new", name="devis_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Devis();
        $request = $this->getRequest();
        $bon_commande_id = $request->query->get('bon_commande_id');
        $this->get('session')->set('bon_commande_id', $bon_commande_id);
        $entity->setBonCommandeId($bon_commande_id);
        $form   = $this->createForm(new DevisType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Devis entity.
     *
     * @Route("/create", name="devis_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Devis:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Devis();
        $request = $this->getRequest();
        $form    = $this->createForm(new DevisType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $postData = $request->request->get('devis');
            $bonCommandeId = $postData['bonCommande'];
            
            $this->get('session')->setFlash('notice', 'Devis a été créé avec succès');
            
            $retour = $request->get('retour');
            if($retour == 1){
              return $this->redirect($this->generateUrl('devis_new', array('bon_commande_id' => $bonCommandeId)));
            }
            else if($retour == 2){
              return $this->redirect($this->generateUrl('devis'));
            }
            else{
              $this->get('session')->set('bon_commande_id', null);
              return $this->redirect($this->generateUrl('boncommande_show', array('id' => $bonCommandeId)));
            }
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Devis entity.
     *
     * @Route("/{id}/edit", name="devis_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Devis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Devis entity.');
        }

        $editForm = $this->createForm(new DevisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Devis entity.
     *
     * @Route("/{id}/update", name="devis_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Devis:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Devis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Devis entity.');
        }

        $editForm   = $this->createForm(new DevisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Devis a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('devis_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Devis entity.
     *
     * @Route("/{id}/delete", name="devis_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid() || $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Devis')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Devis entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Devis a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('devis'));
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
		    return $this->createFormBuilder(new Devis() )
                ->add('bonCommande', 'entity', array('required' => false, 'class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'empty_value' => '--Sélectionnez--'))
                ->getForm()
        ;
	}
}
