<?php

namespace Acme\FmpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\FmpsBundle\Entity\ArticleBonCommande;
use Acme\FmpsBundle\Form\ArticleBonCommandeType;
use Acme\FmpsBundle\Form\BonCommandeType;
use Symfony\Component\HttpFoundation\Response;
use Acme\FmpsBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ArticleBonCommande controller.
 *
 * @Route("/immobilisations")
 */
class ImmobilisationController extends Controller
{
    /**
     * Lists all Ammortisable Articles entities.
     *
     * @Route("/", name="immobilisation")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $params = $this->get('request')->query->get('form');
        $form = $this->getForm();
				$repository = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande');
        $request = $this->getRequest();
        $form->bindRequest($request);

				if ($request->getRequestFormat() == 'csv'){
					  $entities = $paginator->paginate($repository->findAllForImmobilisation($params), $this->get('request')->query->get('page', 1),500);
						$data =  array('entities' => $entities);
            $response = $this->render('AcmeFmpsBundle:Immobilisation:index.csv.twig', $data);
						$response->headers->set('Content-Type', 'text/csv');
						$response->headers->set('Content-Disposition', 'attachment; filename="immobilisations.csv"');

						return $response;
				}
				else{
					$entities = $paginator->paginate($repository->findAllForImmobilisation($params), $this->get('request')->query->get('page', 1),15);
					
		 			return $this->render('AcmeFmpsBundle:Immobilisation:index.html.twig', array( 'entities' => $entities, 'form' => $form->createView() ));
				}

       
    }


	/**
     * Lists all Articles with details.
     *
     * @Route("/stats", name="immobilisation_stats")
     * @Template()
     */
    public function statsAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$repository = $em->getRepository('AcmeFmpsBundle:ArticleBonCommande');
        $entities = $repository->findImmobilisationForStats();
		$rubriques = $annees = $default = $stats = $stats_sum = $stats_per_year = array();
	
		foreach ($entities as $entity){
			$annee = $entity['anneeBc'];
			if ( !in_array($entity['intitule'], $rubriques) ) $rubriques[$entity['id']] = $entity['intitule'];
			if ( !in_array($annee, $annees) ) $annees[] = $annee;
			if (!array_key_exists($annee, $stats_sum)) $stats_sum[$annee] = 0;
			$stats_sum[$annee] += $entity['totalAnnee'];
		}

		$default = array_fill(0, count($annees), 0.00);
		
		foreach ($entities as $entity){
			$annee = $entity['anneeBc'];
			$rubrique = $entity['intitule'];
			if (!array_key_exists($rubrique, $stats)) $stats[$rubrique] = array();
			if (!array_key_exists($annee, $stats[$rubrique])) $stats[$rubrique][$annee] = $default;
			$stats[$rubrique][$annee] = $entity['totalAnnee'];
		}
		
		foreach ($stats as $stat){
		  	foreach ($stat as $key => $value){
				if (!array_key_exists($key, $stats_per_year)) $stats_per_year[$key] = array_fill(0, count($rubrique), 0.00);
				$stats_per_year[$key][] = $value;
			}
		}
		//print_r($stats);exit;
        return $this->render('AcmeFmpsBundle:Immobilisation:stats.html.twig', array('annees' => $annees, 'stats' => $stats, 'stats_sum' => $stats_sum, 'rubriques' =>  $rubriques));
	}
	
	private function getForm()
	{
		$form = $this->createFormBuilder(new ArticleBonCommande() )
				->add('bonCommande', 'entity', array('property_path' => false, 'class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'required'  => false, 'empty_value' => '--Sélectionnez--', 
	                'query_builder' => function (EntityRepository $er) 
	                     {
	                         return $er->createQueryBuilder('b')
	                                ->where('r.ammortissable = 1')
									->leftJoin('b.rubrique', 'r')
							        ->orderBy('b.numero', 'ASC');
								}
			                     ))
                ->add('article', 'entity', array('class' => 'AcmeFmpsBundle:Article', 'label' => 'Article', 'required'  => false, 'empty_value' => '--Sélectionnez--'))
				->add("affectation","text", array("property_path" => false, 'label' => 'Affectation', 'required'  => false, 'attr' => array('placeholder' => 'Affectation') ))
				->add('dateBc', 'date', array("property_path" => false, 'label' => "Date de réception", 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date', 'placeholder' => 'Date de réception')))
				->add('rubrique', 'entity', array('property_path' => false, 'class' => 'AcmeFmpsBundle:Rubrique', 'label' => 'Rubrique', 'required'  => false, 'empty_value' => '--Sélectionnez--', 
	                'query_builder' => function (EntityRepository $er) 
	                     {
	                         return $er->createQueryBuilder('r')
	                                ->where('r.ammortissable = 1')
									->orderBy('r.intitule', 'desc');
	                     }
	                     ))
                ->getForm();
		return $form;
	}
	
}
