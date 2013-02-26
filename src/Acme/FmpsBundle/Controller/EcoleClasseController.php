<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EcoleClasse;
use Acme\FmpsBundle\Entity\Classe;
use Acme\FmpsBundle\Form\EcoleClasseType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EcoleClasse controller.
 *
 * @Route("/ecole_classes")
 */
class EcoleClasseController extends Controller
{
    /**
     * Lists all EcoleClasse entities.
     *
     * @Route("/", name="ecoleclasse")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $form = $this->getForm();

        $form->bindRequest($request);
        $repository = $em->getRepository('AcmeFmpsBundle:EcoleClasse');
				$user = $this->get('security.context')->getToken()->getUser();
        $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $this->get('request')->query->get('page', 1),15);
        
        return $this->render('AcmeFmpsBundle:EcoleClasse:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));

    }

    /**
     * Finds and displays a EcoleClasse entity.
     *
     * @Route("/{id}/show", name="ecoleclasse_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleClasse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EcoleClasse entity.
     *
     * @Route("/new", name="ecoleclasse_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EcoleClasse();
        $form   = $this->createForm(new EcoleClasseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new EcoleClasse entity.
     *
     * @Route("/create", name="ecoleclasse_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleClasse:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EcoleClasse();
        $request = $this->getRequest();
        $form    = $this->createForm(new EcoleClasseType(), $entity);
        $form->bindRequest($request);

				//TODO 
				//create empty classes avec la valeur AD par défaut
				//send notification to the directror

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);

						$classesCount = $entity->getClassesCount();
				    $anneeScolaire = $entity->getAnneeScolaire();
				    $ecole = $entity->getEcole();
				    for($i = 0; $i < $classesCount; $i++)
						{
						  $classe = new Classe();
						  $classe->setEcole($ecole);
						  $classe->setNomClasse('Classe ' . $i);
						  $classe->setAnneeScolaire($anneeScolaire);
					    $em->persist($classe);
						}
						
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'EcoleClasse a été créé avec succès');

            return $this->redirect($this->generateUrl('ecoleclasse_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EcoleClasse entity.
     *
     * @Route("/{id}/edit", name="ecoleclasse_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleClasse entity.');
        }

        $editForm = $this->createForm(new EcoleClasseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EcoleClasse entity.
     *
     * @Route("/{id}/update", name="ecoleclasse_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EcoleClasse:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EcoleClasse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EcoleClasse entity.');
        }

        $editForm   = $this->createForm(new EcoleClasseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'EcoleClasse a été mis à jour avec succès');

            return $this->redirect($this->generateUrl('ecoleclasse_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EcoleClasse entity.
     *
     * @Route("/{id}/delete", name="ecoleclasse_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EcoleClasse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EcoleClasse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        if($request->isXmlHttpRequest())
        {
            $response = new Response(json_encode(array(	'success'=> 1,)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        else 
        {
            return $this->redirect($this->generateUrl('ecoleclasse'));
        }
       
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
		$form = $this->createFormBuilder(new EcoleClasse() )
                ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
				 'required' => false, 
	                'query_builder' => function (EntityRepository $er) 
	                     {
	                         return $er->createQueryBuilder('e')
	                                ->where('e.id > 1');
	                     }
	                     ))
							  ->add('anneeScolaire', 'entity', array('required' => false, 'class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 'empty_value' => '--Sélectionnez--', 
							              'query_builder' => function (EntityRepository $er) 
							                   {
							                       return $er->createQueryBuilder('a')
							                              ->orderBy('a.libelleAnneeScolaire', 'DESC');;
							                   }
							                   ))					
                ->add('classesCount', 'text', array('label' => 'Nombre de classes', 'required' => false,  'attr' => array('placeholder' => 'Nombre de classes')))
								->add('placesCount', 'text', array('label' => 'Nombre de places', 'required' => false,  'attr' => array('placeholder' => 'Nombre de places')))
                ->getForm();
			return $form;
	}
}
