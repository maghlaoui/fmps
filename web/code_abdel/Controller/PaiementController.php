<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Paiement;
use Acme\FmpsBundle\Form\PaiementType;

/**
 * Paiement controller.
 *
 * @Route("/paiements")
 */
class PaiementController extends Controller {

    /**
     * Lists all Paiement entities.
     *
     * @Route("/", name="paiement")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Paiement');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1), 15);

        return $this->render('AcmeFmpsBundle:Paiement:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
    }

    /**
     * Finds and displays a Paiement entity.
     *
     * @Route("/{id}/show", name="paiement_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Paiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paiement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Paiement entity.
     *
     * @Route("/new", name="paiement_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Paiement();
        $request = $this->getRequest();
        $inscription_id = $request->query->get('inscription_id');

        if (empty($inscription_id)) {
            $this->get('session')->setFlash('error', 'Vous devez choisir une inscription à payer');

            return $this->redirect($this->generateUrl('inscription'));
        }

        $em = $this->getDoctrine()->getEntityManager();
        $inscription = $em->getRepository('AcmeFmpsBundle:Inscription')->find($inscription_id);
        if ($inscription)
            $entity->setInscription($inscription);
        $entity->setInscriptionId($inscription_id);
        $entity->setMatricule($inscription->getNumDemande());
        $form = $this->createForm(new PaiementType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Paiement entity.
     *
     * @Route("/create", name="paiement_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Paiement:new.html.twig")
     */
    public function createAction() {
        $entity = new Paiement();
        $request = $this->getRequest();
        $form = $this->createForm(new PaiementType(), $entity);
        $postData = $request->request->get('paiement');
       
        $inscriptionId = $postData['inscriptionId'];


        $form->bindRequest($request);

        if ($form->isValid()) {
          
    
            $em = $this->getDoctrine()->getEntityManager();
            $inscription = $em->getRepository('AcmeFmpsBundle:Inscription')->find($inscriptionId);
  // var_dump(array($inscription->getAnneeScolaire()->getId(),$inscription->getCategoryId(),$inscription->get));die;
                 $dql = "SELECT o.montantService as montant FROM AcmeFmpsBundle:OffreService o 
                 where o.category=".$inscription->getCategoryId()."and o.service=1 and o.anneeScolaire=".$inscription->getAnneeScolaire()->getId();
        $query = $em->createQuery($dql);
            $result = $query->getResult();
           
            $entity->setInscription($inscription);
         
        
            $em->persist($entity);
              $em->flush();
          
     $details = new \Acme\FmpsBundle\Entity\DetailPaiement;
     $details->setPaiementId($entity->getId());
     $details->setServiceId(1);
     $details->setMontant($result[0]['montant']);
         $em->persist($details);
            //$inscription = $entity->getInscription();
            $inscription->setValidated(true);
            $em->persist($inscription);

            $em->flush();

            $this->get('session')->setFlash('notice', 'Paiement des frais d\'inscription a été créé avec succès');
            return $this->redirect($this->generateUrl('paiement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Paiement entity.
     *
     * @Route("/{id}/edit", name="paiement_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Paiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paiement entity.');
        }

        $editForm = $this->createForm(new PaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Paiement entity.
     *
     * @Route("/{id}/update", name="paiement_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Paiement:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Paiement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paiement entity.');
        }

        $editForm = $this->createForm(new PaiementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Paiement des frais d\'inscription a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('paiement_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Paiement entity.
     *
     * @Route("/{id}/delete", name="paiement_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Paiement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Paiement entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Paiement a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('paiement'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    private function getForm() {
        $form = $this->createFormBuilder(new Paiement())
                ->add('matricule', 'text', array('required' => false, 'attr' => array('placeholder' => 'Matricule')))
                ->add('datePaiement', 'date', array('label' => 'Date de paiement', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
                ->add('moyenPaiement', 'choice', array('label' => 'Type de paiement', 'required' => false, 'empty_value' => '--Sélectionnez--', 'choices' => array('Virement' => 'Virement', 'Espèce' => 'Espèce')))
                ->add('nomPersonnePaiement', 'text', array('label' => 'Effectué par', 'required' => false, 'attr' => array('placeholder' => 'Effectué par')))
                ->add('inscription', 'entity', array('class' => 'AcmeFmpsBundle:Inscription', 'label' => 'Enfant', 'empty_value' => '--Sélectionnez--', 'required' => false))
                ->getForm();
        return $form;
    }

}
