<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\ArticleBonCommande;
use Acme\FmpsBundle\Form\ArticleBonCommandeType;
use Symfony\Component\HttpFoundation\Response;
use Acme\FmpsBundle\Entity\Article;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ArticleBonCommande controller.
 *
 * @Route("/article_bon_commande")
 */
class ArticleBonCommandeController extends Controller
{
    /**
     * Lists all ArticleBonCommande entities.
     *
     * @Route("/", name="articleboncommande")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createSearchForm();
        $request = $this->getRequest();
		    $page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page,15);
        
        
        return $this->render('AcmeFmpsBundle:ArticleBonCommande:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a ArticleBonCommande entity.
     *
     * @Route("/{id}/show", name="articleboncommande_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleBonCommande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ArticleBonCommande entity.
     *
     * @Route("/new", name="articleboncommande_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ArticleBonCommande();
        $request = $this->getRequest();
        $bon_commande_id = $request->query->get('bon_commande_id');
        $this->get('session')->set('bon_commande_id', $bon_commande_id);
        $entity->setBonCommandeId($bon_commande_id);
        $form   = $this->createForm(new ArticleBonCommandeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ArticleBonCommande entity.
     *
     * @Route("/create", name="articleboncommande_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ArticleBonCommande:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ArticleBonCommande();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity->setUser($user);
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        
        $postData = $request->request->get('articleboncommande');
        $designation = $postData['article'];
        $bonCommandeId = $postData['bonCommande'];

        $article = $em->getRepository('AcmeFmpsBundle:Article')->findOrCreateByDesignation($designation);
        $entity->setArticle($article);
        
        $form    = $this->createForm(new ArticleBonCommandeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();
           
            $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->updateBonComandeTotal($bonCommandeId);
            $retour = $request->get('retour');
            if($retour == 1){
	
              return $this->redirect($this->generateUrl('articleboncommande_new', array('bon_commande_id' => $bonCommandeId)));
            }
            else if($retour == 2){
              $this->get('session')->set('bon_commande_id', null);

              return $this->redirect($this->generateUrl('articleboncommande'));
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
     * Displays a form to edit an existing ArticleBonCommande entity.
     *
     * @Route("/{id}/edit", name="articleboncommande_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleBonCommande entity.');
        }

        $editForm = $this->createForm(new ArticleBonCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ArticleBonCommande entity.
     *
     * @Route("/{id}/update", name="articleboncommande_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:ArticleBonCommande:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleBonCommande entity.');
        }
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity->setUser($user);
        $request = $this->getRequest();
        $repository = $em->getRepository('AcmeFmpsBundle:Article');
        $postData = $request->request->get('articleboncommande');
        $designation = $postData['article'];
        $bonCommandeId = $postData['bonCommande'];

        $article = $repository->findByDesignation($designation);

        if ($article == null){
            $article = new Article();
            $article->setDesignation($designation);
            $em->persist($article);
            $em->flush();
        }
        
        $entity->setArticle($article);

        $editForm   = $this->createForm(new ArticleBonCommandeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->updateBonComandeTotal($bonCommandeId);

            return $this->redirect($this->generateUrl('boncommande_show', array('id' => $entity->getBonCommandeId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ArticleBonCommande entity.
     *
     * @Route("/{id}/delete", name="articleboncommande_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ArticleBonCommande entity.');
            }
            
            $em->remove($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Article a été supprimé du bon de commande avec succès');
       }

       return $this->redirect($this->generateUrl('boncommande'));  
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
		$form = $this->createFormBuilder(new ArticleBonCommande() )
                ->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'required'  => false, 'empty_value' => '--Sélectionnez--'))
                ->add('article', 'entity', array('class' => 'AcmeFmpsBundle:Article', 'label' => 'Article', 'required'  => false, 'empty_value' => '--Sélectionnez--'))
                ->add('user', 'entity', array('class' => 'AcmeFmpsBundle:User', 'label' => 'Ajouté par', 'required'  => false, 'empty_value' => '--Sélectionnez--'))
                ->getForm();
		return $form;
	}
	
}
