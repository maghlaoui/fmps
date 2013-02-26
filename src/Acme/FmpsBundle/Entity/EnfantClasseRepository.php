<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EnfantClasseRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('ec')
 								 ->select('ec, c, a')
                 ->leftJoin('ec.enfant', 'e')
								 ->leftJoin('ec.classe', 'c')
								 ->leftJoin('ec.anneeScolaire', 'a');


			$ecoles = $user->getEcoles();
    
			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
      {
         $qb->andWhere($qb->expr()->in('i.ecoleId', $ecoles));
      }
      
      if ($options->getEnfant() && $options->getEnfant() != '')
      {
          $qb->andWhere('ec.enfantId = :enfant')->setParameter('enfant', $options->getEnfant());
      }

      if ($options->getClasses() && $options->getClasses() != '')
      {
          $qb->andWhere('ec.classeId = :classe')->setParameter('classe', $options->getClasses());
      }

      if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('ec.anneeScolaireId = :as')->setParameter('as', $options->getAnneeScolaire());
      }

      
      return $qb->getQuery();
    }

   public function getCount($entity)
   {
			$enfantId = $entity->getEnfantId();
	    if ( empty($enfantId )) $enfantId = $entity->getEnfant()->getId();
			$anneeScolaireId = $entity->getAnneeScolaireId();
	    if ( empty($anneeScolaireId )) $anneeScolaireId = $entity->getAnneeScolaire()->getId();
			$classeId = $entity->getClasseId();
	    if ( empty($classeId )) $classeId = $entity->getClasse()->getId();

			$qb = $this->createQueryBuilder('ec')
								 ->select('COUNT(ec)')
								 ->andWhere('ec.enfantId = :e_id')->setParameter('e_id', $enfantId)
								 ->andWhere('ec.anneeScolaire = :as_id')->setParameter('as_id', $anneeScolaireId)
								 ->andWhere('ec.classeId = :c_id')->setParameter('c_id', $classeId);

		  return $qb->getQuery()->getSingleScalarResult();
   }
    
}