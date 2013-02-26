<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EcoleBudgetRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('eb')
								 ->select('eb, budget, rubrique')
			           ->leftJoin('eb.ecole', 'ecole')
                 ->leftJoin('eb.budget', 'budget')
							   ->leftJoin('budget.rubrique', 'rubrique');
							
			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
		  {
				  $qb->andWhere($qb->expr()->in('eb.ecoleId', $ecoles));
			}
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('eb.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getBudget() && $options->getBudget() != '')
      {
          $qb->andWhere('eb.budgetId = :b_id')->setParameter('b_id', $options->getBudget()); 
      }
      
      return $qb->getQuery();
    }

		public function getExistedEcoles($budgetId)
    {
		  $result = $this->createQueryBuilder('eb')
								 ->select('eb.ecoleId')
								 ->andWhere('eb.budgetId = '.$budgetId)
								 ->getQuery()
								 ->getScalarResult();
								
		  return array_map('current', $result);
	  }
       
}