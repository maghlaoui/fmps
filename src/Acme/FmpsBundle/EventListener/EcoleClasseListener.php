<?php

namespace Acme\FmpsBundle\Listener;
 
use Doctrine\ORM\Event\LifecycleEventArgs;
use Acme\FmpsBundle\Entity\EcoleClasse;
use Acme\FmpsBundle\Entity\Classe;
 
class EcoleClasseListener
{
    public function postPersist(LifecycleEventArgs $args) {
 
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
 
        if ($entity instanceof EcoleClasse) {

			    $classesCount = $entity->getClassesCount();
			    $anneeScolaire = $entity->getAnneeScolaire();
			    $ecole = $entity->getEcole();
			    for($i = 0; $i < $classesCount; $i++)
					{
					  $classe = new Classe();
					  $classe->setEcole($ecole);
					  $classe->setNomClasse('Classe ' . $i);
					  $classe->setAnneeScolaire($anneeScolaire);
					  $classe->setEcole($ecole);
				    $em->persist($classe);
					}
					
			    $em->flush();
        }
    }
}