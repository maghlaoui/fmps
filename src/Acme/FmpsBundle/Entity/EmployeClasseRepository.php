<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class EmployeClasseRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('e')
								 ->select('e, em, c, a')
         				 ->leftJoin('e.employe', 'em')
								 ->leftJoin('e.classe', 'c')
         				 ->leftJoin('e.anneeScolaire', 'a');

			if ($user && $user->hasRole('ROLE_DIRECTEUR'))
		  {
				 $employes = $user->getEmployes();
				 $qb->andWhere($qb->expr()->in('e.employeId', $employes));
			} 
      
      if ($options->getEmploye() && $options->getEmploye() != '')
      {
          $qb->andWhere('e.employeId = :employe')->setParameter('employe', $options->getEmploye());
      }
      
      if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('e.anneeScolaireId = :as')->setParameter('as', $options->getAnneeScolaire());
      }

			if ($options->getClasse() && $options->getClasse() != '')
      {
          $qb->andWhere('e.classeId = :c_id')->setParameter('c_id', $options->getClasse());
      }
      
      return $qb->getQuery();
    }

   public function getCount($entity)
   {
			$employeId = $entity->getEmployeId();
	    if ( empty($employeId )) $employeId = $entity->getEmploye()->getId();
			$anneeScolaireId = $entity->getAnneeScolaireId();
	    if ( empty($anneeScolaireId )) $anneeScolaireId = $entity->getAnneeScolaire()->getId();
			$classeId = $entity->getClasseId();
	    if ( empty($classeId )) $classeId = $entity->getClasse()->getId();

			$qb = $this->createQueryBuilder('ec')
								 ->select('COUNT(ec)')
								 ->andWhere('ec.employeId = :e_id')->setParameter('e_id', $employeId)
								 ->andWhere('ec.anneeScolaire = :as_id')->setParameter('as_id', $anneeScolaireId)
								 ->andWhere('ec.classeId = :c_id')->setParameter('c_id', $classeId);
								
		  return $qb->getQuery()->getSingleScalarResult();
   }
    
}