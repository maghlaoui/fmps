<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\SituationCaisse;
use Acme\FmpsBundle\Form\SituationCaisseType;
use Doctrine\ORM\EntityRepository;

/**
 * SituationCaisse controller.
 *
 * @Route("/situation_caisse")
 */
class SituationCaisseController extends Controller {

  /**
   * Lists all SituationCaisse entities.
   *
   * @Route("/", name="situationcaisse")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getEntityManager();

    $paginator = $this->get('knp_paginator');
    $request = $this->getRequest();
    $form = $this->createSearchForm();


    $form->bindRequest($request);
    $repository = $em->getRepository('AcmeFmpsBundle:SituationCaisse');
    $user = $this->get('security.context')->getToken()->getUser();
    $entities = $paginator->paginate($repository->findBySearchCriteria($form->getData(), $user), $request->query->get('page', 1), 15);

    return $this->render('AcmeFmpsBundle:SituationCaisse:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
  }

  /**
   * Finds and displays a SituationCaisse entity.
   *
   * @Route("/{id}/show", name="situationcaisse_show")
   * @Template()
   */
  public function showAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find SituationCaisse entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
        'entity' => $entity,
        'delete_form' => $deleteForm->createView(),);
  }

  /**
   * Displays a form to create a new SituationCaisse entity.
   *
   * @Route("/new", name="situationcaisse_new")
   * @Template()
   */
  public function newAction() {

    $entity = new SituationCaisse();
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->get('security.context')->getToken()->getUser();
       
 
    $ecole = $user->getEmploye()->getEcole()->getId();
   
    $default = new \Acme\FmpsBundle\Entity\SituationCaisse;
    /*     * *********************recuperation des derniers cloture*********************** */
    $situation_non_cloturer = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->findBy(array('ecoleId' => $ecole, 'cloture' => 0), array('id' => 'DESC'));
    $situation_cloturer = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->findBy(array('ecoleId' => $ecole, 'cloture' => 1), array('id' => 'DESC'));

    if (!$situation_non_cloturer && !$situation_cloturer) {
      $datetoday=getDate();
    $varmoisapres=$entity->querymoisapres($datetoday['mon']);
  
      

      $moisDetail[1] = $varmoisapres[1];
      $moisDetail[0] =$varmoisapres[0];
      $annee = $datetoday['year'];
      /*       * ******************************total alimentation********************************* */
      $st_alimentation = $default->queryAlimentation($em, $ecole, $moisDetail[0], $annee);
      $st_alimentation_all = $default->queryAlimentationAll($em, $ecole, $moisDetail[0], $annee);
      $result_alimentation = $st_alimentation->getResult();
      $result_alimentation_all = $st_alimentation_all->getResult();
      
      if ($result_alimentation[0]['montantAlimentation']) {
        $entity->setTotalAlimentation($result_alimentation[0]['montantAlimentation']);
      } else {
        $entity->setTotalAlimentation(0, 00);
      }

      /*       * **********************************st total********************* */
      $st_decharge = $default->queryDecharge($em, $ecole, $moisDetail[0], $annee);
       $st_decharge_all = $default->queryDechargeAll($em, $ecole, $moisDetail[0], $annee);
      $st_eau_electricite = $default->queryEauElectricite($em, $ecole, $moisDetail[0], $annee);
       $st_eau_electricite_all = $default->queryEauElectriciteAll($em, $ecole, $moisDetail[0], $annee);
      $st_facture = $default->queryFacture($em, $ecole, $moisDetail[0], $annee);
      $st_facture_all = $default->queryFactureAll($em, $ecole, $moisDetail[0], $annee);
      $st_bon = $default->queryBon($em, $ecole, $moisDetail[0], $annee);
$st_bon_all = $default->queryBonAll($em, $ecole, $moisDetail[0], $annee);
      /*       * ***********************************resultats*********************** */
      $result_decharge = $st_decharge->getResult();
       $result_decharge_all = $st_decharge_all->getResult();
      $result_eau_electricite = $st_eau_electricite->getResult();
      $result_eau_electricite_all = $st_eau_electricite_all->getResult();
      $result_facture = $st_facture->getResult();
      $result_facture_all = $st_facture_all->getResult();
      $result_bon = $st_bon->getResult();
       $result_bon_all = $st_bon_all->getResult();

      /*       * ***********************************Total********************************* */
      $total = $result_decharge[0]['montantDecharge'] + $result_bon[0]['montantBon'] + $result_eau_electricite[0]['montantEau'] + $result_facture[0]['montantFacture'];

      /*       * ************************************* solde final***************************** */
      $solde_final = ($result_alimentation[0]['montantAlimentation']) - $total;
      $entity->setMois($moisDetail[1]);
      $entity->setAnnee("2013");
      $entity->setTotalAchat($total);
      $entity->setSoldeFinale($solde_final);
      $form = $this->createForm(new SituationCaisseType(), $entity, array('user' => $user));

      $data = array('entity' => $entity, 'ecole' => $user->getEmploye()->getEcole(),
          'directeur' => $user->getEmploye(), 'objet' => $result_facture_all,
          'alimentation' => $result_alimentation_all,'decharge'=>$result_decharge_all,
          'eau'=>$result_eau_electricite_all,'bon'=>$result_bon_all
      );
 $request = $this->getRequest();
      if ($request->getRequestFormat() == 'pdf') {
        $html = $this->renderView('AcmeFmpsBundle:SituationCaisse:new.pdf.twig', $data);
        $file = 'situation_' . $entity->getId() . '.pdf';
        return $this->get('io_tcpdf')->quick_pdf($html, $file);
      }
    }
    if ($situation_non_cloturer) {

      $moisDetail = $situation_non_cloturer[0]->getMois();
      $annee = $situation_non_cloturer[0]->getAnnee();
      $this->get('session')->setFlash('error', 'vous devez cloturer le mois ' . $moisDetail . ' de ' . $annee . ' avant de pouvoir cloturer le mois suivant');
      return $this->redirect($this->generateUrl('situationcaisse'));
    }

    if ($situation_cloturer) {

      $moisDetail1 = $situation_cloturer[0]->getMois();
      $moisDetail = $entity->querymoisapres($moisDetail1);
       $datetoday=getDate();
      $annee = $datetoday['year'];;

      /*       * ************************* solde initial******************************** */
      //$situation_cloturer = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->findBy(array('ecoleId' => $ecole, 'cloture' => 1), array('id' => 'DESC'));
      $entity->setSoldeInitiale($situation_cloturer[0]->getSoldeFinale());

      /*       * ********************************total alimentation********************************* */
      $st_alimentation = $default->queryAlimentation($em, $ecole, $moisDetail[0], $annee);
      
      $st_alimentation_all = $default->queryAlimentationAll($em, $ecole, $moisDetail[0], $annee);
      $result_alimentation = $st_alimentation->getResult();
      $result_alimentation_all = $st_alimentation_all->getResult();

      if ($result_alimentation[0]['montantAlimentation']) {
        $entity->setTotalAlimentation($result_alimentation[0]['montantAlimentation']);
      } else {
        $entity->setTotalAlimentation(0, 00);
      }

      /*       * ***********************************st total********************* */
      $st_decharge = $default->queryDecharge($em, $ecole, $moisDetail[0], $annee);
       $st_decharge_all = $default->queryDechargeAll($em, $ecole, $moisDetail[0], $annee);
      $st_eau_electricite = $default->queryEauElectricite($em, $ecole, $moisDetail[0], $annee);
        $st_eau_electricite_all = $default->queryEauElectriciteAll($em, $ecole, $moisDetail[0], $annee);
      $st_facture = $default->queryFacture($em, $ecole, $moisDetail[0], $annee);
      $st_facture_all = $default->queryFactureAll($em, $ecole, $moisDetail[0], $annee);
      $st_bon = $default->queryBon($em, $ecole, $moisDetail[0], $annee);
$st_bon_all = $default->queryBonAll($em, $ecole, $moisDetail[0], $annee);
      /*       * *********************************resultats*********************** */
      $result_decharge = $st_decharge->getResult();
       $result_decharge_all = $st_decharge_all->getResult();
      $result_eau_electricite = $st_eau_electricite->getResult();
      $result_eau_electricite_all = $st_eau_electricite_all->getResult();
      $result_facture = $st_facture->getResult();
      $result_facture_all = $st_facture_all->getResult();
      $result_bon = $st_bon->getResult();
$result_bon_all = $st_bon_all->getResult();
      /*       * ************************************Total********************************* */
      $total = $result_decharge[0]['montantDecharge'] + $result_bon[0]['montantBon'] + $result_eau_electricite[0]['montantEau'] + $result_facture[0]['montantFacture'];

      /*       * *************************************** solde final***************************** */
      $solde_final = (($situation_cloturer[0]->getSoldeFinale()) + ($result_alimentation[0]['montantAlimentation'])) - $total;
      $entity->setMois($moisDetail[1]);
      $entity->setAnnee($annee);
      $entity->setTotalAchat($total);
      $entity->setSoldeFinale($solde_final);
      $form = $this->createForm(new SituationCaisseType(), $entity, array('user' => $user));

      $data = array('entity' => $entity, 'ecole' => $user->getEmploye()->getEcole(),
          'directeur' => $user->getEmploye(), 'objet' => $result_facture_all,
          'alimentation' => $result_alimentation_all,'decharge'=>$result_decharge_all,
          'eau'=>$result_eau_electricite_all,'bon'=>$result_bon_all
      );
      $request = $this->getRequest();
      if ($request->getRequestFormat() == 'pdf') {
        $html = $this->renderView('AcmeFmpsBundle:SituationCaisse:new.pdf.twig', $data);

        $file = 'situation_' . $entity->getId() . '.pdf';
        return $this->get('io_tcpdf')->quick_pdf($html, $file);
      }
    }
    return array(
        'entity' => $entity,
        'form' => $form->createView(),
        'mois' => $moisDetail[0],
        'annee' => $annee,
        'mois_libelle' => $moisDetail[1]
    );
  }

  /**
   * Creates a new SituationCaisse entity.
   *
   * @Route("/create", name="situationcaisse_create")
   * @Method("post")
   * @Template("AcmeFmpsBundle:SituationCaisse:new.html.twig")
   */
  public function createAction() {

    $em = $this->getDoctrine()->getEntityManager();
    $entity = new SituationCaisse();
    $user = $this->get('security.context')->getToken()->getUser();
    $form = $this->createForm(new SituationCaisseType(), $entity, array('user' => $user));
    $request = $this->getRequest();
    $form->bindRequest($request);

    /*     * *********************recuperer total**************************** */
    $user = $this->get('security.context')->getToken()->getUser();
    $ecole = $user->getEmploye()->getEcole()->getId();
    $default = new \Acme\FmpsBundle\Entity\SituationCaisse;

    /*     * ****************************************set mois************************** */
    $mois = $request->query->get('mois');
    $mois_libelle = $request->query->get('mois_libelle');
    $entity->setMois($mois_libelle);

    /*     * **************************************set annee********************* */
    $annee = $request->query->get('annee');
    $entity->setAnnee($annee);

    /*     * *****************************st total********************* */
    $st_decharge = $default->queryDecharge($em, $ecole, $mois, $annee);
    $st_eau_electricite = $default->queryEauElectricite($em, $ecole, $mois, $annee);
    $st_facture = $default->queryFacture($em, $ecole, $mois, $annee);
    $st_bon = $default->queryBon($em, $ecole, $mois, $annee);
    $st_alimentation = $default->queryAlimentation($em, $ecole, $mois, $annee);

    /*     * ********************************resultats*********************** */
    $result_decharge = $st_decharge->getResult();
    $result_eau_electricite = $st_eau_electricite->getResult();
    $result_facture = $st_facture->getResult();
    $result_bon = $st_bon->getResult();

    /*     * *******************************Total********************************* */
    $total = $result_decharge[0]['montantDecharge'] + $result_bon[0]['montantBon'] + $result_eau_electricite[0]['montantEau'] + $result_facture[0]['montantFacture'];

    if ($form->isValid()) {

      /*       * ********************************set total alimentation***************************** */
      $result_alimentation = $st_alimentation->getResult();
      $entity->setTotalAlimentation($result_alimentation[0]['montantAlimentation']);

      /*       * *********************************set soldeInitial*************************** */
      $situation_cloturer = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->findBy(array('ecoleId' => $ecole, 'cloture' => 1), array('id' => 'DESC'));
      if ($situation_cloturer) {
        $entity->setSoldeInitiale($situation_cloturer[0]->getSoldeFinale());
      } else {
        $entity->setSoldeInitiale($result_alimentation[0]['montantAlimentation']);
      }

      /*       * ************************************Set total_achat**************************** */
      $entity->setTotalAchat($total);

      /*       * **********************************Set solde_finale**************************** */
      if ($situation_cloturer) {
        $solde_final = (($situation_cloturer[0]->getSoldeFinale()) + ($result_alimentation[0]['montantAlimentation'])) - $total;
      } else {
        $solde_final = ($result_alimentation[0]['montantAlimentation']) - $total;
      }
      $entity->setSoldeFinale($solde_final);

      /*       * ***********************************persist***************************** */
      $em->persist($entity);
      $em->flush();

      $this->get('session')->setFlash('notice', 'Situation de caisse a été créée avec succès');
      return $this->redirect($this->generateUrl('situationcaisse_show', array('id' => $entity->getId())));
    }

    return array(
        'entity' => $entity,
        'form' => $form->createView()
    );
  }

  /**
   * Displays a form to edit an existing SituationCaisse entity.
   *
   * @Route("/{id}/edit", name="situationcaisse_edit")
   * @Template()
   */
  public function editAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find SituationCaisse entity.');
    }

    $user = $this->get('security.context')->getToken()->getUser();
    $editForm = $this->createForm(new SituationCaisseType(), $entity, array('user' => $user));
    $deleteForm = $this->createDeleteForm($id);

    return array(
        'entity' => $entity,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits an existing SituationCaisse entity.
   *
   * @Route("/{id}/update", name="situationcaisse_update")
   * @Method("post")
   * @Template("AcmeFmpsBundle:SituationCaisse:edit.html.twig")
   */
  public function updateAction($id) {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find SituationCaisse entity.');
    }

    $user = $this->get('security.context')->getToken()->getUser();
    $editForm = $this->createForm(new SituationCaisseType(), $entity, array('user' => $user));
    $deleteForm = $this->createDeleteForm($id);

    $request = $this->getRequest();

    $editForm->bindRequest($request);

    if ($editForm->isValid()) {
      $em->persist($entity);
      $em->flush();

      $this->get('session')->setFlash('notice', 'Situation de caisse a a été mise à jour avec succès');
      return $this->redirect($this->generateUrl('situationcaisse_show', array('id' => $id)));
    }

    return array(
        'entity' => $entity,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a SituationCaisse entity.
   *
   * @Route("/{id}/delete", name="situationcaisse_delete")
   * @Method("post")
   */
  public function deleteAction($id) {
    $form = $this->createDeleteForm($id);
    $request = $this->getRequest();

    $form->bindRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getEntityManager();
      $entity = $em->getRepository('AcmeFmpsBundle:SituationCaisse')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find SituationCaisse entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    $this->get('session')->setFlash('notice', 'Situation de caisse a a été supprimée avec succès');
    return $this->redirect($this->generateUrl('situationcaisse'));
  }

  private function createDeleteForm($id) {
    return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm()
    ;
  }

  private function createSearchForm() {
    $user = $this->get('security.context')->getToken()->getUser();
    $ecoles = $user->getEcoles();
    if (!empty($ecoles) && !in_array(1, $ecoles)) {
      $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
    } else {
      $where = 'e.id > 1';
    }

    $form = $this->createFormBuilder(new SituationCaisse())
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole',
                'empty_value' => '--Sélectionnez--', 'required' => false,
                'query_builder' => function (EntityRepository $er) use ($where) {
                  return $er->createQueryBuilder('e')
                          ->where($where);
                }
            ))
            ->add('mois', 'text', array('required' => false))
            ->add('annee', 'text', array('required' => false, 'label' => 'Année'))
            ->getForm();

    return $form;
  }

}
