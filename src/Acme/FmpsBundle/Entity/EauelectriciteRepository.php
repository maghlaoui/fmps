<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EauelectriciteRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('e')
					->select('e, ec')
					->leftJoin('e.ecole', 'ec')
					->orderBy('e.createdAt', 'ASC');
					
			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
		  {
				  $qb->andWhere($qb->expr()->in('e.ecoleId', $ecoles));
			}					
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('e.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getBudget() && $options->getBudget() != '')
      {
          $qb->andWhere('e.budgetId = :b_id')->setParameter('b_id', $options->getBudget()); 
      }
      
      if ($options->getNumfacture() && $options->getNumfacture() != '')
      {
          $qb->andWhere('e.numfacture = :num')->setParameter('num', $options->getNumfacture());
      }
      
      if ($options->getFournisseur() && $options->getFournisseur() != '')
      {
          $qb->andWhere('e.fournisseur = :four')->setParameter('four', $options->getFournisseur());
      }
      
      return $qb->getQuery();
    }
       
}