<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class AffectationRepository extends EntityRepository
{
    
	public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('a')
          ->select('a, ec, em, f')
          ->leftJoin('a.ecole', 'ec')
		      ->leftJoin('a.employe', 'em')
			    ->leftJoin('em.fonction', 'f')
          ->orderBy('a.id', 'desc');

			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
	    {
	        $qb->andWhere($qb->expr()->in('a.ecoleId', $ecoles));
					$qb->andWhere('a.dateFinAffectation IS NULL');
	    }
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('a.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }
      
      if ($options->getDateDebutAffectation() && $options->getDateDebutAffectation() != '')
      {
          $qb->andWhere('a.dateDebutAffectation = :date_debut')->setParameter('date_debut', $options->getDateDebutAffectation());
      }
     
      if ($options->getDateFinAffectation() && $options->getDateFinAffectation() != '')
      {
          $qb->andWhere('a.dateFinAffectation = :date_fin')->setParameter('date_fin', $options->getDateFinAffectation());
      }
      
      return $qb->getQuery();
    }

		public function getCurrentAffectations($ecoleId){
			$qb = $this->createQueryBuilder('a')
								 ->select('a')
								 ->leftJoin('a.employe', 'e')
								 ->leftJoin('e.fonction', 'f')
								 ->andWhere('a.dateFinAffectation IS NULL')
								 ->andWhere('a.ecoleId =' .$ecoleId)
								 ->orderBy('a.dateDebutAffectation', 'ASC');

			return $qb->getQuery()->getResult();
		}
		
		public function getRecentAffectation($employeId){
			$qb = $this->createQueryBuilder('a')
								 ->select('a')
								 ->orderBy('a.dateDebutAffectation', 'DESC');

			return $qb->getQuery()->getFirstResult();
		}
		
		public function getExAffectation($id, $employeId){
			$qb = $this->createQueryBuilder('a')
								 ->select('a')
								 ->andWhere('a.employeId ='. $employeId)
								 ->andWhere('a.dateFinAffectation IS NULL')
								 ->andWhere("a.id NOT IN ($id)");

			return $qb->getQuery()->getFirstResult();
		}
}