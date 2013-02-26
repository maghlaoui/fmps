<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class AlimentationRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('a')
					->select('a, e, u')
					->leftJoin('a.ecole', 'e')
					->leftJoin('a.user', 'u')
					->orderBy('a.createdAt', 'ASC');

			$ecoles = $user->getEcoles();

		  if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
					$qb->andWhere($qb->expr()->in('e.id', $ecoles));
			}
				
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('a.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }
      
      if ($options->getNumero() && $options->getNumero() != '')
      {
          $qb->andWhere('a.numero = :numero')->setParameter('numero', $options->getNumero());
      }
     
      if ($options->getDate() && $options->getDate() != '')
      {
          $qb->andWhere('a.date = :date')->setParameter('date', $options->getDate());
      }
      
      if ($options->getMontant() && $options->getMontant() != '')
      {
          $qb->andWhere('a.montant = :montant')->setParameter('montant', $options->getMontant());
      }
      
      return $qb->getQuery();
    }
       
}