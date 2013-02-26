<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Attachement;
use Acme\FmpsBundle\Form\AttachementType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Attachement controller.
 *
 * @Route("/attachement")
 */
class AttachementController extends Controller {

    /**
     * Lists all Attachement entities.
     *
     * @Route("/", name="attachement")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        if (count($request->query->all()) > 0) {//on teste si des valeurs sont transmises par get
            $form->bindRequest($request);
            $repository = $em->getRepository('AcmeFmpsBundle:Attachement');
            $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1), 4);
        } else {
            $entitiess = $em->getRepository('AcmeFmpsBundle:Attachement')->findAll();
            $entities = $paginator->paginate($entitiess, $request->query->get('page', 1), 4);
        }
        return $this->render('AcmeFmpsBundle:Attachement:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
    }

    /**
     * Finds and displays a Attachement entity.
     *
     * @Route("/{id}/show", name="attachement_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Attachement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Attachement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    

    private function getForm() {
        $form = $this->createFormBuilder(new Attachement())
                ->add('Actualite', 'entity', array('class' => 'AcmeFmpsBundle:Actualite', 'label' => 'Actualite', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->getForm();
        return $form;
    }

}
