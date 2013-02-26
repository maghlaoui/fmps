<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EcoleClasseRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('e')->select('e');
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('e.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }
      
     	if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('e.anneeScolaire = :as')->setParameter('as', $options->getAnneeScolaire()); 
      }

			if ($options->getClassesCount() && $options->getClassesCount() != '')
      {
          $qb->andWhere('e.calssesCount = :cc')->setParameter('cc', $options->getClassesCount()); 
      }

			if ($options->getPlacesCount() && $options->getPlacesCount() != '')
      {
          $qb->andWhere('e.placesCount = :pc')->setParameter('pc', $options->getPlacesCount()); 
      }
      
      return $qb->getQuery();
    }

    public function getCountByEcoleId($ecoleId){
        return $this->createQueryBuilder('e')
		   		 ->select('e.placesCount')
           ->andWhere('e.ecoleId = :id')
           ->setParameter('id', $ecoleId)
 					 ->orderBy('anneeScolaireId', 'DESC') 
           ->getQuery()
           ->getSingleScalarResult();
    }
       
}