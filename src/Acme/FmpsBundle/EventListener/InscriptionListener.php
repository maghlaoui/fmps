<?php

namespace Acme\FmpsBundle\Listener;
 
use Acme\FmpsBundle\Entity\Inscription;
use Acme\FmpsBundle\Entity\Service;
use Acme\FmpsBundle\Entity\OffreService;
use Acme\FmpsBundle\Entity\InscriptionOffreService;
 
use Doctrine\ORM\Event\LifecycleEventArgs;
 
class InscriptionListener
{
    public function postPersist(LifecycleEventArgs $args) {
 
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
 
        if ($entity instanceof Inscription) {
 
            if( $entity->getEcole() ) {
								//Select Offres de service obligatoires pour cet école et les ajouter à cet inscription
								$offres_service = $em->getRepository('AcmeFmpsBundle:OffreService')->getOffresService( $entity->getAnneeScolaireId(), $entity->getEcoleId() );
								$months = array(9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre', 
								1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin');
								$mois = $entity->getDateEntree()->format('m');
							  $status = 0;
								foreach ($offres_service as $offre_service){
									
		              $service = $offre_service->getService();
									if ( $service->getObligatoire() == 1)
									{
										if ( $offre_service->getMois() == 1 )
										{
											//Add offre service for all months
											foreach ($months as $key => $value)
											{
												$inscriptionOffreService = new InscriptionOffreService();
				                $inscriptionOffreService->setMois($value);
				                $inscriptionOffreService->setOffreService($offre_service);
				                $inscriptionOffreService->setInscription($entity);
												if ( $status == 0 && $mois == $key ) $status = 1;
												$inscriptionOffreService->setStatus($status);
												$em->persist($inscriptionOffreService);
											}
										}
										else
										{
											//Add offre service only one time (frais d'inscription)
											$inscriptionOffreService = new InscriptionOffreService();
			                $inscriptionOffreService->setOffreService($offre_service);
			                $inscriptionOffreService->setInscription($entity);
											$inscriptionOffreService->setStatus(1);
											$em->persist($inscriptionOffreService);
										}
									}
		            }
								
                $em->flush();
            }
        }

        
   }
}