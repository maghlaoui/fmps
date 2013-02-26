<?php

namespace Acme\FmpsBundle\Listener;
 
use Doctrine\ORM\Event\LifecycleEventArgs;
 
class AffectationListener
{
    public function postPersist(LifecycleEventArgs $args) {
 
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
 
        if ($entity instanceof Affectation) {
	        $employe = $entity->getEmploye();
			    $affectation = $employe->getRecentAffectation();
			    if ( $affectation ){
					  $employe->setEcole($affectation->getEcole());
				    $em->persist($employe);
				 
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