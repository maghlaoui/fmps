<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\Inscription;
use Acme\FmpsBundle\Form\InscriptionType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Inscription controller.
 *
 * @Route("/reinscriptions")
 */
class ReinscriptionController extends Controller
{
    /**
     * Displays a form to create a new Inscription entity.
     *
     * @Route("/new", name="reinscription_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Inscription();
				$user = $this->get('security.context')->getToken()->getUser();
        $form   = $this->createForm(new InscriptionType(), $entity, array('user' => $user));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Inscription entity.
     *
     * @Route("/create", name="reinscription_create")
     * @Method("post")
     * @Template("AcmeFmpsBundle:Reinscription:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Inscription();
        $request = $this->getRequest();
				$user = $this->get('security.context')->getToken()->getUser();
        $form    = $this->createForm(new InscriptionType(), $entity, array('user' => $user));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
						$em->flush();
					
 						$this->get('session')->set('inscription_id', $entity->getId());
						$this->get('session')->setFlash('notice', 'Inscription a été ajoutée avec succès');
            return $this->redirect($this->generateUrl('paiement_new', array('inscription_id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

}
