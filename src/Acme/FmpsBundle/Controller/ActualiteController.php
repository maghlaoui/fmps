<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Actualite;
use Acme\FmpsBundle\Form\ActualiteType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Actualite controller.
 *
 * @Route("/actualite")
 */
class ActualiteController extends Controller {

    /**
     * Lists all Actualite entities.
     *
     * @Route("/", name="actualite")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:Actualite');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $request->query->get('page', 1), 15);
        return $this->render('AcmeFmpsBundle:Actualite:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
    }

    /**
     * Finds and displays a Actualite entity.
     *
     * @Route("/{id}/show", name="actualite_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('AcmeFmpsBundle:Actualite')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actualite entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Actualite entity.
     *
     * @Route("/new", name="actualite_new")
     * @Template()
     */
    public function newAction() {
        $message = '';
        $actualite = new Actualite();
        $form = $this->container->get('form.factory')->create(new ActualiteType(), $actualite);
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->container->get('doctrine')->getEntityManager();
                $user = $this->container->get('security.context')->getToken()->getUser();
                $postData = $request->request->get('actualite');
                $actualite->setUserId($user->getEmployeId());
                $actualite->setCreatedAt(new \DateTime);
                $actualite->setRoles(serialize($postData['roles']));
                $em->persist($actualite);
                $em->flush();
                $default = new \Acme\FmpsBundle\Entity\Actualite;
                $st = $default->findLastId($em);
                $result = $st->getResult();
                if (isset($_POST['d1']) || isset($_POST['d2'])) {
                    if ($_POST['d1'] && !isset($_POST['d2'])) {
                        $c = $_POST['d1'];
                        $attachement = new \Acme\FmpsBundle\Entity\Attachement;
                        $attachement->setActualite((int) $result[0]['id']);
                        $attachement->setFichier($c);
                        $em->persist($attachement);
                        $em->flush();
                    } else if ($_POST['d2'] && !isset($_POST['d1'])) {
                        $c = $_POST['d2'];
                        $attachement = new \Acme\FmpsBundle\Entity\Attachement;
                        $attachement->setActualite((int) $result[0]['id']);
                        $attachement->setFichier($c);
                        $em->persist($attachement);
                        $em->flush();
                    } else if ($_POST['d1'] && $_POST['d2']) {
                        $c = array($_POST['d1'], $_POST['d2']);
                        foreach ($c as $arr) {
                            $attachement = new \Acme\FmpsBundle\Entity\Attachement;
                            $attachement->setActualite((int) $result[0]['id']);
                            $attachement->setFichier($arr);
                            $em->persist($attachement);
                            $em->flush();
                        }
                    }
                    $this->get('session')->setFlash('notice', 'Actualité a été créé avec succès');
                    return $this->redirect($this->generateUrl('actualite'));
                } else {
                    $this->get('session')->setFlash('notice', 'Actualité a été créé avec succès');
                    return $this->redirect($this->generateUrl('actualite'));
                }
            }
        }
        return $this->container->get('templating')->renderResponse('AcmeFmpsBundle:Actualite:new.html.twig', array('form' => $form->createView(), 'message' => $message,));
    }

    /**
     * Displays a form to edit an existing Actualite entity.
     *
     * @Route("/{id}/edit", name="actualite_edit")
     * @Template()
     */
    public function editAction($id) {
        $message = '';
        $em = $this->container->get('doctrine')->getEntityManager();
        if (isset($id)) {
            // modification d'un bon existant : on recherche ses données
            $actualite = $em->find('AcmeFmpsBundle:Actualite', $id);
            if (!$actualite) {
                $message = 'Aucune Actualité trouvé';
            }
        } else {
            $actualite = new Actualite();
        }
        $form = $this->container->get('form.factory')->create(new ActualiteType(), $actualite);
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $actualite->setUpdatedAt(new \DateTime);
                $em->persist($actualite);
                $em->flush();
                $this->get('session')->setFlash('notice', 'Actualité a été mis à jour avec succès');
                return $this->redirect($this->generateUrl('actualite_show', array('id' => $id)));
            }
        }
        return $this->container->get('templating')->renderResponse('AcmeFmpsBundle:Actualite:edit.html.twig', array('form' => $form->createView(), 'entity' => $actualite, 'message' => $message,));
    }

    /**
     * Deletes a Actualite entity.
     *
     * @Route("/{id}/delete", name="actualite_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Actualite')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bon entity.');
            }
            $em->remove($entity);
            $em->flush();
        }
        if ($request->isXmlHttpRequest()) {
            $response = new Response(json_encode(array('success' => 1,)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $this->get('session')->setFlash('notice', 'Actualité a été supprimé avec succés');
            return $this->redirect($this->generateUrl('actualite'));
        }
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    private function getForm() {
        $form = $this->createFormBuilder(new Actualite())
                ->add('rubrique', 'entity', array('class' => 'AcmeFmpsBundle:ActualiteRubrique', 'label' => 'Rubrique', 'required' => false, 'empty_value' => '--Sélectionnez--'))
                ->add('title', 'text', array('required' => false, 'attr' => array('placeholder' => 'titre')))
                ->add('createdAt', 'date', array('required' => false, 'label' => 'Date', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
                ->getForm();
        return $form;
    }

}
