<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Util\FmpsLists;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Contact controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="dashboard")
     * @Template()
     */
    public function indexAction() {
           $user = $this->container->get('security.context')->getToken()->getUser();
           
           $em = $this->getDoctrine()->getEntityManager();

        $default = new \Acme\FmpsBundle\Entity\User;
        $st = $default->lookforfirtconnecte($user->getId(), $em);
        $result = $st->getResult();
//  var_dump((int) $result[0]['first_connect']);die;
//if( !(int) $result[0]['firstConnect']){
	if( 1 == 3){
    
    return $this->redirect($this->generateUrl('user_password_reset_first_use', array('id' => $user->getId())));
//    var_dump($userMotDePasse);die;
    
    
}else{
        $em = $this->getDoctrine()->getEntityManager();

        $default = new \Acme\FmpsBundle\Entity\Actualite;
        $st = $default->queryAll($em);
        $result = $st->getResult();
        return array('entities' => $result);
    }
    }
    /**
     * Finds and displays a Attachement entity.
     *
     * @Route("/{id}/show", name="default_show")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getEntityManager();

        $default = new \Acme\FmpsBundle\Entity\Actualite;
        $st = $default->query($id, $em);
        $result = $st->getResult();
        return array('entities' => $result);
    }

    /**
     * Finds and displays current user profile.
     *
     * @Route("/profile", name="profile")
     * @Template()
     */
    public function profileAction($id) 
    {
        $current_user = $this->get('security.context')->getToken()->getUser();

        return array('entity' => $current_user, 'default_roles'       => FmpsLists::getRolesList());
    }

		/**
     * displays unauthorized page
     *
     * @Route("unauthorized", name="unauthorized")
     * @Template()
     */
		public function unauthorizedAction()
		{
		 $this->get('session')->setFlash('error', 'Vous n\'avez pas le droit d\'accéder à cette ressource mais vous pouvez le demander auprès du service informatique');
		//TODO write 403 error to  log file
		return $this->render('AcmeFmpsBundle:Default:unauthorized.html.twig');
		}

}
