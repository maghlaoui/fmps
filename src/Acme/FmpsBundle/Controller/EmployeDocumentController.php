<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\EmployeDocument;
use Acme\FmpsBundle\Form\EmployeDocumentType;
use Acme\FmpsBundle\Form\TypeDocumentType;
use Acme\FmpsBundle\Entity\TypeDocument;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EmployeDocument controller.
 *
 * @Route("/employedocument")
 */
class EmployeDocumentController extends Controller
{
    /**
     * Lists all EmployeDocument entities.
     *
     * @Route("/", name="employedocument")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeFmpsBundle:EmployeDocument')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a EmployeDocument entity.
     *
     * @Route("/{id}/show", name="employedocument_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeDocument entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EmployeDocument entity.
     *
     * @Route("/new", name="employedocument_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EmployeDocument();

				$employeId = $this->getRequest()->query->get('employe_id');

				if ( !empty($employeId) ){
					$em = $this->getDoctrine()->getEntityManager();
					$employe = $em->getRepository('AcmeFmpsBundle:Employe')->find($employeId);
					$entity->setEmploye($employe);
				}
					
        $form   = $this->createForm(new EmployeDocumentType(), $entity);
				
        $type_document = new TypeDocument();
        $type_document_form   = $this->createForm(new TypeDocumentType(), $type_document);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'type_document_form'   => $type_document_form->createView()
        );
    }

    /**
     * Creates a new EmployeDocument entity.
     *
     * @Route("/create", name="employedocument_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeDocument:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EmployeDocument();
        $request = $this->getRequest();
        $form    = $this->createForm(new EmployeDocumentType(), $entity);
        $form->bindRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
	
            $em->persist($entity);
            $em->flush();
						
						$this->get('session')->setFlash('notice', 'Document a été ajouté avec succès');
						$employeId = $entity->getEmploye()->getId();
            return $this->redirect($this->generateUrl('employe_show', array('id' => $employeId)));
            
        }

				$type_document = new TypeDocument();
	      $type_document_form   = $this->createForm(new TypeDocumentType(), $type_document);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
						'type_document_form'   => $type_document_form->createView()
        );
    }

    /**
     * Displays a form to edit an existing EmployeDocument entity.
     *
     * @Route("/{id}/edit", name="employedocument_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeDocument entity.');
        }

        $editForm = $this->createForm(new EmployeDocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EmployeDocument entity.
     *
     * @Route("/{id}/update", name="employedocument_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:EmployeDocument:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:EmployeDocument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeDocument entity.');
        }

        $editForm   = $this->createForm(new EmployeDocumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
						$this->get('session')->setFlash('notice', 'Document a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('employedocument_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EmployeDocument entity.
     *
     * @Route("/{id}/delete", name="employedocument_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeFmpsBundle:EmployeDocument')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmployeDocument entity.');
            }

						$this->get('session')->setFlash('notice', 'Document a été supprimé avec succès');
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('employedocument'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
