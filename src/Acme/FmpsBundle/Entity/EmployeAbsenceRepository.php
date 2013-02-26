<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class EmployeAbsenceRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('ea')
									->select('ea, e')->leftJoin('ea.employe', 'e');
									
			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
				$qb->andWhere($qb->expr()->in('e.ecoleId', $ecoles));
		  }									 
     
      if ($options->getEmployeId() && $options->getEmployeId() != '')
      {
          $qb->andWhere('e.nom LIKE :nom')->setParameter('nom', '%'.$options->getEmployeId().'%');
      }
      
      if ($options->getMotif() && $options->getMotif() != '')
      {
          $qb->andWhere('ea.motif = :motif')->setParameter('motif', $options->getMotif());
      }
      
      if ($options->getDu() && $options->getDu() != '')
      {
          $qb->andWhere('ea.du >= :du')->setParameter('du', $options->getDu());
      }

			if ($options->getAu() && $options->getAu() != '')
      {
          $qb->andWhere('ea.au <= :au')->setParameter('au', $options->getAu());
      }
      
      return $qb->getQuery();
    }

    public function getAllWithEmploye()
    {
    
      $qb = $this->createQueryBuilder('ea')
         ->select('ea, e')
         ->addOrderBy('ea.id', 'ASC')
         ->innerJoin('ea.employe', 'e');
      
      return $qb->getQuery();
      
    }

    public function getCount($entity)
    {
	    $employeId = $entity->getEmployeId();
	    if ( empty($employeId )) $employeId = $entity->getEmploye()->getId();
      $qb = $this->createQueryBuilder('ea')
         ->select('COUNT(ea)')
				 ->andWhere('ea.employeId = :id')->setParameter('id', $employeId)
         ->andWhere('ea.du <= :du')->setParameter('du', $entity->getDu()->format('Y-m-d'));

      return $qb->getQuery()->getSingleScalarResult();
      
    }
    
}