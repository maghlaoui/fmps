<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class SituationCaisseRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('s')
								 ->select('s, e')
			           ->leftJoin('s.ecole', 'e');

			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
				 $qb->andWhere($qb->expr()->in('s.ecoleId', $ecoles));
			}

      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('s.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getMois() && $options->getMois() != '')
      {
          $qb->andWhere('s.mois = :mois')->setParameter('mois', $options->getMois()); 
      }

			if ($options->getAnnee() && $options->getAnnee() != '')
      {
          $qb->andWhere('s.annee = :annee')->setParameter('annee', $options->getAnnee()); 
      }
      
      return $qb->getQuery();
    }
    
}