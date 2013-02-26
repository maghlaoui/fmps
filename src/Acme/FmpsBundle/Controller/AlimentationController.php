<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Alimentation;
use Acme\FmpsBundle\Form\AlimentationType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Alimentation controller.
 *
 * @Route("/alimentations")
 */
class AlimentationController extends Controller
{
    /**
     * Lists all Alimentation entities.
     *
     * @Route("/", name="alimentation")
     * @Template()
     */
    public function indexAction()
    {
	      $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();
        $form->bindRequest($request);
        $page = $request->query->get('page', 1);
        $repository = $em->getRepository('AcmeFmpsBundle:Alimentation');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $page, 15);
       
        return $this->render('AcmeFmpsBundle:Alimentation:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Alimentation entity.
     *
     * @Route("/{id}/show", name="alimentation_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alimentation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Toggle Reception.
     *
     * @Route("/{id}/reception", name="alimentation_reception")
     * @Template()
		 * @Secure(roles="ROLE_DC")
     */
    public function receptionAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alimentation entity.');
        }
				//TODO check if user is owner of the ecole
        $entity->setReception(1);

				$em->persist($entity);
        $em->flush();

				$this->get('session')->setFlash('notice', 'Alimentation a été marqué comme reçu');

        return $this->redirect($this->generateUrl('alimentation'));
    }

    /**
     * Displays a form to create a new Alimentation entity.
     *
     * @Route("/new", name="alimentation_new")
     * @Template()
		 * @Secure(roles="ROLE_DC")
     */
    public function newAction()
    {
        $entity = new Alimentation();
				$request = $this->getRequest();
        $id = $request->query->get('id');
				$em = $this->getDoctrine()->getEntityManager();
        $alimentation = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);
				if ( $alimentation )
				{
					$entity->setObjet($alimentation->getObjet());
					$entity->setMontant($alimentation->getMontant());
					$entity->setDate($alimentation->getDate());
				}
        $form   = $this->createForm(new AlimentationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Alimentation entity.
     *
     * @Route("/create", name="alimentation_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Alimentation:new.html.twig")
		 * @Secure(roles="ROLE_DC")
     */
    public function createAction()
    {
        $entity  = new Alimentation();
        $request = $this->getRequest();
        $form    = $this->createForm(new AlimentationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $user = $this->container->get('security.context')->getToken()->getUser();
		        $entity->setUser($user);
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Alimentation a été créé avec succès');

						$retour = $request->get('retour');

            if($retour == 1){
              return $this->redirect($this->generateUrl('alimentation_new', array('id' => $entity->getId())));
            }
            else {
	            return $this->redirect($this->generateUrl('alimentation'));
            }

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Alimentation entity.
     *
     * @Route("/{id}/edit", name="alimentation_edit")
     * @Template()
		 * @Secure(roles="ROLE_DC")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alimentation entity.');
        }

        $editForm = $this->createForm(new AlimentationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Alimentation entity.
     *
     * @Route("/{id}/update", name="alimentation_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Alimentation:edit.html.twig")
		 * @Secure(roles="ROLE_DC")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alimentation entity.');
        }

        $editForm   = $this->createForm(new AlimentationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Alimentation a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('alimentation_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Alimentation entity.
     *
     * @Route("/{id}/delete", name="alimentation_delete")
     * @Method("post")
		 * @Secure(roles="ROLE_DC")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Alimentation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alimentation entity.');
            }

            $em->remove($entity);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Alimentation a été supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('alimentation'));
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
		
			$form = $this->createFormBuilder(new Alimentation() )
	                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
					 'required' => false, 
		                'query_builder' => function (EntityRepository $er) use ($where)
		                     {
		                         return $er->createQueryBuilder('e')
		                                ->where($where);
		                     }
		                     ))
	                ->add('numero', 'text', array('label' => 'Numéro', 'required' => false, 'attr' => array('placeholder' => 'Numéro du compte')))
	                ->add('montant', 'text', array('required' => false, 'attr' => array('placeholder' => 'Numéro du compte')))
	                ->add('date', 'date', array('required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
	                ->getForm();
				return $form;
		}
}
