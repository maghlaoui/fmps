<?php

namespace Acme\FmpsBundle\Listener;
 
use Doctrine\ORM\Event\LifecycleEventArgs;
 
class AffectationListener
{
    public function postPersist(LifecycleEventArgs $args) {
 
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
 echo ' A am here'; exit;
        if ($entity instanceof Affectation) {
	        $employeId = $entity->getEmployeId();
			    $affectation = $em->getRepository('AcmeFmpsBundle:Affectation')->getRecentAffectation($employeId);
			    if ( $affectation ){
			      $employe = $affectation->getEmploye();
						$ecole = $affectation->getEcole();
					  $employe->setEcole($ecole);
				    $em->persist($employe);
				    echo 'Employe id: ' . $affectation->getEmploye()->getId();
				    echo '   Ecole id: ' . $affectation->getEcole()->getId();exit;
				    //Set date fin affectation when new affectation is created
				    $ex = $em->getRepository('AcmeFmpsBundle:Affectation')->getExAffectation($affectation->getId());
				    if ( $ex )
				    {
					    $ex->setDateFinAffectation(new \DateTime());
					    $em->persist($ex);
				    }
					}
					
			    $em->flush();
        }
    }

    public function postRemove(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Affectation) {
					$affectation = $em->getRepository('AcmeFmpsBundle:Affectation')->getRecentAffectation($employeId);
			    if ( $affectation ){
				    $employe = $affectation->getEmploye();
						$employe->setEcole($affectation->getEcole());
					  $em->persist($employe);
			    }
			    else
			    {
						$employe = $entity->getEmploye();
						$employe->setEcole(null);
					  $em->persist($employe);
			    }
					
			    $em->flush();
        }
    }


}