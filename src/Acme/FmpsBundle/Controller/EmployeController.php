<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Employe;
use Acme\FmpsBundle\Entity\Affectation;
use Acme\FmpsBundle\Entity\Fonction;
use Acme\FmpsBundle\Entity\EmployeFonction;
use Acme\FmpsBundle\Form\EmployeType;
use Acme\FmpsBundle\Form\AffectationType;
use Acme\FmpsBundle\Form\FonctionType;
use Acme\FmpsBundle\Util\FmpsLists;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Employe controller.
 *
 * @Route("/employes")
 */
class EmployeController extends Controller
{
    /**
     * Lists all Employe entities.
     *
     * @Route("/", name="employe")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('AcmeFmpsBundle:Employe');

        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
				$page = $this->get('request')->query->get('page', 1);
        $form = $this->getForm();
        $form->bindRequest($request);
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData()), $page, 15);
       
        return $this->render('AcmeFmpsBundle:Employe:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
    }

    /**
     * Finds and displays a Employe entity.
     *
     * @Route("/{id}/show", name="employe_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Employe')->getOneWithAssociation($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));
				$request = $this->getRequest();
				
        $data =  array( 'entity' => $entity, 
											  'user'   => $user, 
											  'default_roles'  => FmpsLists::getRolesList(), );
        
        if ($request->getRequestFormat() == 'pdf'){
	
            $html = $this->renderView('AcmeFmpsBundle:Employe:show.pdf.twig', $data);
		        $file = 'employe_'.$entity->getId().'.pdf';
            return $this->get('io_tcpdf')->quick_pdf($html, $file);
        }

        return array(
            'entity'      => $entity,
            'user' => $user,
						'fonctions' => $entity->getFonctions(),
						'documents' => $entity->getDocuments(),
						'absences' => $entity->getAbsences(),
            'default_roles'       => FmpsLists::getRolesList(),
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Employe entity.
     *
     * @Route("/new", name="employe_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Employe();
        $form   = $this->createForm(new EmployeType(), $entity);

				$fonction = new Fonction();
	      $fonction_form = $this->createForm(new FonctionType(), $fonction);
	
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'fonction_form' => $fonction_form->createView(),
        );
    }

    /**
     * Creates a new Employe entity.
     *
     * @Route("/create", name="employe_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Employe:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Employe();
        $request = $this->getRequest();

        $form    = $this->createForm(new EmployeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
	          
            $em = $this->getDoctrine()->getEntityManager();

						$postData = $request->request->get('fonction_type');
						if ( $postData && $postData['libele'] ) 
						{
							$libele = $postData['libele'];
							$fonction = $em->getRepository('AcmeFmpsBundle:Fonction')->findOrCreateByLibelle($libele);
			        if ( $fonction ) $entity->setFonction($fonction);
						}
			      
            $em->persist($entity);

            $postData = $request->request->get('employe');

						$logger = $this->get('logger');

						//Create affectation
						$logger->info('Create affectation');
						$affectation  = new Affectation();
						$affectation->setEmploye($entity);
						$affectation->setEcole($entity->getEcole());
						if ( !empty ( $postData['dateAffectation'] )) $affectation->setDateDebutAffectation(new \DateTime($postData['dateAffectation']));
						$em->persist($affectation);
						
						//Create fonction
						$logger->info('Create fonction');
						$fonction  = new EmployeFonction();
						$fonction->setEmploye($entity);
						$fonction->setFonction($entity->getFonction());
						if ( !empty ( $postData['dateFonction'] )) $fonction->setDateDebutFonction(new \DateTime($postData['dateFonction']));
						$em->persist($fonction);
						
            $em->flush();

						$logger->info('Create user');
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setUsername($entity->getUsername());
            $user->setEmail($entity->getEmail());
            $user->setPlainPassword($entity->getCin());
            $user->setEnabled(true);
            if ( !empty($postData['roles']) ) $user->setRoles($postData['roles']);
            $user->setEmploye($entity);
            $userManager->updateUser($user);
						
						$logger->info('Send email');
						$message = \Swift_Message::newInstance()
						        ->setSubject('Votre compte')
						        ->setFrom('amaghlaoui@fmps.ma')
						        ->setTo($entity->getEmail())
						        ->setBody($this->renderView('AcmeFmpsBundle:Employe:email.html.twig', array('username' => $entity->getUsername(), 'password' => $entity->getCin())))
						    ;
						$this->get('mailer')->send($message);

            $this->get('session')->setFlash('notice', 'Employé a été ajouté avec succès');

            return $this->redirect($this->generateUrl('employe_show', array('id' => $entity->getId())));
            
        }
				else
				{ 
       	  $fonction = new Fonction();
	        $fonction_form = $this->createForm(new FonctionType(), $fonction);

          return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fonction_form'   => $fonction_form->createView()
          );
        }
    }


    /**
     * Displays a form to edit an existing Employe entity.
     *
     * @Route("/{id}/edit", name="employe_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Employe')->find($id);
        $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $editForm = $this->createForm(new EmployeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
						'user'   => $user,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Employe entity.
     *
     * @Route("/{id}/update", name="employe_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Employe:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Employe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }
       
        $editForm   = $this->createForm(new EmployeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Employé a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('employe_show', array('id' => $id)));
        }

        $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));

        return array(
            'entity' => $entity,
						'user'   => $user,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Employe entity.
     *
     * @Route("/{id}/delete", name="employe_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
	      //TODO 
	      //delete affectations, fonctions
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid() || $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:Employe')->find($id);
            $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Employe entity.');
            }

            $em->remove($entity);
            $em->remove($user);
            $em->flush();

						$this->get('session')->setFlash('notice', 'Employé a été supprimé avec succès');
            
        }
        
				return $this->redirect($this->generateUrl('employe'));
      
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
		$form = $this->createFormBuilder(new Employe())
            ->add('matricule','text', array( 'required' => false, 'attr' => array('placeholder' => 'Matricule', 'class' => 'span2') ))
            ->add('nom','text', array( 'required' => false, 'attr' => array('placeholder' => 'Nom', 'class' => 'span2') ))
            ->add('prenom','text', array( 'required' => false, 'label' => 'Prénom', 'attr' => array('placeholder' => 'Prénom', 'class' => 'span2') ))
            ->add('tel','text', array( 'required' => false, 'attr' => array('placeholder' => 'Téléphone') ))
            ->add('fonction','entity',array('class' => 'AcmeFmpsBundle:Fonction', 'empty_value' => '--Fonction--', 'required' => false ))
						->add('ecole','entity',array('class' => 'AcmeFmpsBundle:Ecole', 'empty_value' => '--Affectation--', 'required' => false, 'label' => 'Affectation' ))
			      
            ->getForm();
		return $form;
	}
	
	/**
	     * Creates a new Employe entity.
	     *
	     * @Route("/ajaxmatricule", name="employe_ajaxmatricule")
	     * @Method("post")
	     * @Template("AcmeFmpsBundle:Employe:index.html.twig")
	     */
	    public function ajaxmatriculeAction()
	    {
	      $request = $this->get('request');
	      $name = $request->request->get('query');
	      $em = $this->getDoctrine()->getEntityManager();
	      $user = $em->getRepository('AcmeFmpsBundle:employe')->findOneBy(array('matricule' => $name));
	      $return = json_encode($user);
	      return new Response($return, 200, array('Content-Type' => 'application/json'));
	    }
	
	
	/**
	  * Check users account.
	  *
		* @Route("/check_accounts", name="check_accounts")
		* @Method("get")
		*/	
	public function check_accounts()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('AcmeFmpsBundle:Employe')->findAll();

		foreach ($entities as $entity){

			$user = $em->getRepository('AcmeFmpsBundle:User')->findByEmployeId($entity->getId());
			$cin = $entity->getCin();
			if ( empty($cin)) $cin = '123456';
			if ( !$user ){
				$userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($entity->getUsername());
        $user->setEmail($entity->getEmail());
        $user->setPlainPassword($cin);
        $user->setEnabled(true);
        $user->setEmploye($entity);
        $userManager->updateUser($user);
			}
		}
		echo 'it is done';
	  exit;
	}
	
	
}
