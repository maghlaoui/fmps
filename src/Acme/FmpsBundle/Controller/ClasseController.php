<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Classe;
use Acme\FmpsBundle\Form\ClasseType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Classe controller.
 *
 * @Route("/classes")
 */
class ClasseController extends Controller
{
    /**
     * Lists all Classe entities.
     *
     * @Route("/", name="classe")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getSearchForm();
        $page = $this->get('request')->query->get('page', 1);
        $form->bindRequest($request);

        $repository = $em->getRepository('AcmeFmpsBundle:Classe');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page, 15);
        
        return $this->render('AcmeFmpsBundle:Classe:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a Classe entity.
     *
     * @Route("/{id}/show", name="classe_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

				$educateurs = $em->getRepository('AcmeFmpsBundle:EmployeClasse')->findByClasseId($id);
				$enfants = $em->getRepository('AcmeFmpsBundle:EnfantClasse')->findByClasseId($id);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
						'educateurs'  => $educateurs,
						'enfants'     => $enfants,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Classe entity.
     *
     * @Route("/new", name="classe_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Classe();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new ClasseType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Classe entity.
     *
     * @Route("/create", name="classe_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Classe:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Classe();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new ClasseType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Classe a été créé avec succès');

						$retour = $request->get('retour');
						
            if($retour == 1){
	
              return $this->redirect($this->generateUrl('classe_new'));
            }
            else if($retour == 2){
	
              return $this->redirect($this->generateUrl('classe'));
            }
            else{
	
              return $this->redirect($this->generateUrl('classe_show', array('id' => $entity->getId())));
            }
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Classe entity.
     *
     * @Route("/{id}/edit", name="classe_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
				$editForm = $this->createForm(new ClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Classe entity.
     *
     * @Route("/{id}/update", name="classe_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Classe:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

				$user = $this->get('security.context')->getToken()->getUser();
        $editForm   = $this->createForm(new ClasseType(), $entity, array('user' => $user));
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Classe a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('classe_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Classe entity.
     *
     * @Route("/{id}/delete", name="classe_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Classe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Classe entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Classe a été supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('classe')); 
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
		$user = $this->get('security.context')->getToken()->getUser();
		$ecoles = $user->getEcoles();
    if ( !empty($ecoles) && !in_array(1, $ecoles) )
    {
       $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
    }
    else{
       $where = 'e.id > 1';
    }
		$form = $this->createFormBuilder(new Classe() )
                ->add('nomClasse', 'text', array('label' => 'Nom', 'required' => false, 'attr' => array('placeholder' => 'Nom')))
                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
				 'required' => false, 
	                'query_builder' => function (EntityRepository $er) use ($where)
	                     {
	                         return $er->createQueryBuilder('e')
	                                ->where($where);
	                     }
	                     ))
                ->add('section', 'entity', array('class' => 'AcmeFmpsBundle:Section', 'label' => 'Section', 'empty_value' => '--Sélectionnez--',
								 'required' => false))
									->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--',
									 'required' => false))
                ->getForm();
			return $form;
	}
}
