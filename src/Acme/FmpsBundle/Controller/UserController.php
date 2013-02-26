<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\User;
use Acme\FmpsBundle\Form\UserType;
use Acme\FmpsBundle\Form\PasswordResetType;
use Symfony\Component\HttpFoundation\Response;
use Acme\FmpsBundle\Util\FmpsLists;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * User controller.
 *
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
				$paginator = $this->get('knp_paginator');
				$form = $this->getSearchForm();
			  $current_page = $this->get('request')->query->get('page', 1);
        $request = $this->getRequest();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:User');
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $current_page,25);


        return $this->render('AcmeFmpsBundle:User:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_show")
     * @Template()
		 * @Secure(roles="ROLE_SUPER_ADMIN, ROLE_DRH")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'entity'      => $entity,
            'default_roles'       => FmpsLists::getRolesList(),        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="user_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:User:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm   = $this->createForm(new UserType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            
            $userManager = $this->get('fos_user.user_manager');
            $entity->setUsername($editForm->get('username')->getData());
            $entity->setEmail($editForm->get('email')->getData());
            $entity->setEnabled($editForm->get('enabled')->getData());
            $entity->setRoles($editForm->get('roles')->getData());
            $userManager->updateUser($entity);
            
            $this->get('session')->setFlash('notice', 'Utilisateur a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

	private function getSearchForm()
	{
		 $form = $this->createFormBuilder(new User() )
                ->add('username', 'text', array('required' => false, 'attr' => array('placeholder' => 'Identifiant')))
                ->add('email', 'text', array('required' => false, 'attr' => array('placeholder' => 'Email')))
                ->getForm();
	   return $form;
	}
	
	/**
   * Reset User passwor.
   *
   * @Route("/{id}/password_reset", name="user_password_reset")
   * @Template()
   */
  public function password_resetAction($id)
  {
      $em = $this->getDoctrine()->getEntityManager();

      $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find User entity.');
      }

      $editForm = $this->createForm(new PasswordResetType(), $entity);

      return array(
          'entity'      => $entity,
          'edit_form'   => $editForm->createView(),
      );
  }
	
	/**
   * Edits an existing User entity.
   *
   * @Route("/{id}/update_password", name="user_password_update")
   * @Method("post")
   * @Template("AcmeFmpsBundle:User:password_reset.html.twig")
   */
  public function updatePasswordAction($id)
  {
      $em = $this->getDoctrine()->getEntityManager();

      $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find User entity.');
      }

      $editForm   = $this->createForm(new PasswordResetType(), $entity);

      $request = $this->getRequest();

      $editForm->bindRequest($request);
      
      if ($editForm->isValid()) {
          
          $userManager = $this->get('fos_user.user_manager');
					$entity->setPlainPassword($editForm->get('password')->getData());
          $userManager->updateUser($entity);
          
          $this->get('session')->setFlash('notice', 'Mot de passe a été mis à jour avec succès');

          return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
      }

      return array(
          'entity'      => $entity,
          'edit_form'   => $editForm->createView(),
      );
  }
	

}
