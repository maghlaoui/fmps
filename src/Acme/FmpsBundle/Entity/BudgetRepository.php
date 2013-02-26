<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class BudgetRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('b')->select('b, r')->leftJoin('b.rubrique', 'r');; 
      
      if ($options->getRubrique() && $options->getRubrique() != '')
      {
          $qb->andWhere('b.rubriqueId = :rubrique_id')->setParameter('rubrique_id', $options->getRubrique()); 
      }

	    if ($options->getAnnee() && $options->getAnnee() != '')
      {
          $qb->andWhere('b.annee = :annee')->setParameter('annee', $options->getAnnee()); 
      }
      
      return $qb->getQuery();
    }
    
}