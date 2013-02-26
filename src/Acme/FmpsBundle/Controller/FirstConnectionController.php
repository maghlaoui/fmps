<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Acme\FmpsBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Form\PasswordResetType;
use Acme\FmpsBundle\Form\EmployeType;
use Acme\FmpsBundle\Form\EcoleType;

class FirstConnectionController extends Controller {

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="firstConnection")
     * @Template()
     */
    public function indexAction() {}

    /**
     * Reset User passwor.
     *
     * @Route("/{id}/lister", name="lister_ecoles")
     * @Template()
     */
    public function listerEcolesAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $st = $em->createQuery("SELECT e FROM AcmeFmpsBundle:Affectation a , AcmeFmpsBundle:Ecole e where a.ecole=e.id and a.employe =" . $id);
        $result = $st->execute();
        $a = &$result;
        $i = 0;
        return array(
            'entity' => $a[$i],
            'user' => $user->getId(),
        );
    }

    /**
     * Reset User passwor.
     *
     * @Route("/{id}/password_reset_first", name="user_password_reset_first_use")
     * @Template()
     */
    public function password_reset_firstuseAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new PasswordResetType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update_password_first", name="user_password_update_firstuse")
     * @Method("post")
     * @Template("AcmeFmpsBundle:FirstConnection:password_reset_firstuse.html.twig")
     */
    public function updatePasswordfirstuseAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new PasswordResetType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($editForm->isValid()) {

            //$ancien=$editForm->get('ancien')->getData();
if($user->getPassword()!=$_POST['ancien']){ 
    $this->get('session')->setFlash('error', 'ancien mot de passe incorrect');}

else{
            /* on vérifie que la code est toujours mémorisé en session et qu'il fait 6 caractères */
        
                $userManager = $this->get('fos_user.user_manager');
                $entity->setPlainPassword($editForm->get('password')->getData());
                $userManager->updateUser($entity);

                $this->get('session')->setFlash('notice', 'Mot de passe a été mis à jour avec succès');

                return $this->redirect($this->generateUrl('employe_edit_first', array('id' => $id)));
}
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'user' => $user->getId(),
        );
    }

    /**
     * Displays a form to edit an existing Employe entity.
     *
     * @Route("/{id}/edit", name="employe_edit_first")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Employe')->find($id);
        $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $editForm = $this->createForm(new EmployeType(), $entity);

        return array(
            'entity' => $entity,
            'user' => $user->getId(),
            'form' => $editForm->createView(),
            'userr' => 0,
        );
    }

    /**
     * Edits an existing Employe entity.
     *
     * @Route("/{id}/update", name="employe_direct_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:FirstConnection:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeFmpsBundle:Employe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $editForm = $this->createForm(new EmployeType(), $entity);

        $st = $em->createQuery("SELECT e FROM AcmeFmpsBundle:Affectation a , AcmeFmpsBundle:Ecole e where a.ecole=e.id and a.employe =" . $id);

        $result = $st->execute();
        $a = &$result;

        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();
            $user = $this->container->get('security.context')->getToken()->getUser();
            $this->get('session')->setFlash('notice', 'Profil complet');

            return $this->redirect($this->generateUrl('directeur_ecoles_editer', array('id' => $a[0]->getId())));
        }

        $user = $em->getRepository('AcmeFmpsBundle:User')->findOneBy(array('employeId' => $id));

        return array(
            'entity' => $entity,
            'user' => $user->getId(),
            'form' => $editForm->createView(),
            'userr' => 0,
        );
    }

    /**
     * Displays a form to edit an existing Ecole entity.
     *
     * @Route("/{id}/edite", name="directeur_ecoles_editer")
     * @Template()
     */
    public function ecoleEditAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ecole entity.');
        }

        $editForm = $this->createForm(new EcoleType(), $entity);
        if (isset($_GET['i'])) {
            $p = $_GET['i'];
        } else {
            $p = 0;
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'user' => $user->getId(),
            'userr' => $p,
        );
    }

    /**
     * Edits an existing Ecole entity.
     *
     * @Route("/{id}/updatee", name="ecoles_update")
     * @Method("post")
     * @Template("AcmeFmpsBundle:FirstConnection:ecoleEdit.html.twig")
     */
    public function updateEcoleAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('AcmeFmpsBundle:Ecole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ecole entity.');
        }

        $editForm = $this->createForm(new EcoleType(), $entity);

        $request = $this->getRequest();
        $st = $em->createQuery("SELECT e FROM AcmeFmpsBundle:Affectation a , AcmeFmpsBundle:Ecole e where a.ecole=e.id and a.employe =" . $id);

        $result = $st->execute();
        $a = &$result;
        $i = $_GET['i'] + 1;

        //  var_dump(empty($a[0]));die;
        $editForm->bindRequest($request);
        if (isset($a[$i])) {

//            if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', 'ecole editer');

            return $this->redirect($this->generateUrl('directeur_ecoles_editer', array('id' => $a[$i]->getId(), 'i' => $i + 1)));
//            }
        } else {
//            if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Bienvenue');
            $st = $em->createQuery("Update AcmeFmpsBundle:User u set u.first_connect=1 where u.id =" . $user->getId());
            $result1 = $st->execute();
            return $this->redirect($this->generateUrl('dashboard'));
//            }
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'user' => $user->getId(),
            'userr' => $i + 1,
        );
    }



}

?>
