<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Ville;
use Acme\FmpsBundle\Form\VilleType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * Ville controller.
 *
 * @Route("/villes")
 */
class VilleController extends Controller
{
    /**
     * Lists all Ville entities.
     *
     * @Route("/", name="ville")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT v FROM AcmeFmpsBundle:Ville v ORDER BY v.libelleVille";
        
        $query = $em->createQuery($dql);
        
        $paginator = $this->get('knp_paginator');

        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1), 15);

        return $this->render('AcmeFmpsBundle:Ville:index.html.twig', array( 'entities' => $entities ));
    }

    /**
     * Finds and displays a Ville entity.
     *
     * @Route("/{id}/show", name="ville_show")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Ville entity.
     *
     * @Route("/new", name="ville_new")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function newAction()
    {
        $entity = new Ville();
        $form   = $this->createForm(new VilleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Ville entity.
     *
     * @Route("/create", name="ville_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Ville:new.html.twig")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function createAction()
    {
        $entity  = new Ville();
        $request = $this->getRequest();
        $form    = $this->createForm(new VilleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Ville a été créé avec succès');
            
            return $this->redirect($this->generateUrl('ville_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Ville entity.
     *
     * @Route("/{id}/edit", name="ville_edit")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $editForm = $this->createForm(new VilleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Ville entity.
     *
     * @Route("/{id}/update", name="ville_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Ville:edit.html.twig")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $editForm   = $this->createForm(new VilleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Ville a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('ville_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ville entity.
     *
     * @Route("/{id}/delete", name="ville_delete")
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
            $entity = $em->getRepository('AcmeFmpsBundle:Ville')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ville entity.');
            }
            
            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Ville a été supprimée avec succès');  
        }
        
        return $this->redirect($this->generateUrl('ville'));
        
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
}
