<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EcoleAchatRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('a')
								 ->select('a, e, b')
			           ->leftJoin('a.ecole', 'e')
                 ->leftJoin('a.budget', 'b'); 

			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
				 $qb->andWhere($qb->expr()->in('a.ecoleId', $ecoles));
			}

      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('a.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getBudget() && $options->getBudget() != '')
      {
          $qb->andWhere('a.budgetId = :b_id')->setParameter('b_id', $options->getBudget()); 
      }

			if ($options->getFournisseur() && $options->getFournisseur() != '')
      {
          $qb->andWhere('a.fournisseur = :f')->setParameter('f', $options->getFournisseur()); 
      }

			if ($options->getModePayement() && $options->getModePayement() != '')
      {
          $qb->andWhere('a.modePayement = :mp')->setParameter('mp', $options->getModePayement()); 
      }
      
      return $qb->getQuery();
    }
    
}