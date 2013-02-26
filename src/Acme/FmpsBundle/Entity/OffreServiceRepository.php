<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class OffreServiceRepository extends EntityRepository
{
	public function findBySearchCriteria($options, $user)
    {
      $qb = $this->createQueryBuilder('o')
 								 ->select('o, e, a, s, c')
				         ->leftJoin('o.ecole', 'e')
								 ->leftJoin('o.anneeScolaire', 'a')
				         ->leftJoin('o.service', 's')
				         ->leftJoin('o.category', 'c');
      
							$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
				 $qb->andWhere($qb->expr()->in('o.ecoleId', $ecoles));
			}
				
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('o.ecoleId = :ecole')->setParameter('ecole', $options->getEcole());
      }

			if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('o.anneeScolaireId = :annee')->setParameter('annee', $options->getAnneeScolaire());
      }

			if ($options->getService() && $options->getService() != '')
      {
          $qb->andWhere('o.serviceId = :service')->setParameter('service', $options->getService());
      }

			if ($options->getCategory() && $options->getCategory() != '')
      {
          $qb->andWhere('o.categoryId = :category')->setParameter('category', $options->getCategory());
      }
      
      return $qb->getQuery();
    }

		public function findByEcoleId($ecole_id)
	    {
	      $qb = $this->createQueryBuilder('o')->select('o')->andWhere('o.ecoleId = :ecole')->setParameter('ecole', $ecole_id);
				return $qb->getQuery()->gerResult();
			}
			
			
			public function getOffresService( $annee_scolaire_id, $ecole_id ) 
			{
				$qb = $this->createQueryBuilder('o')
									 ->select('o, s')
									 ->distinct('o.serviceId')
	       					 ->addOrderBy('o.anneeScolaireId', 'DESC')
	       					 ->leftJoin('o.service', 's')
								   ->andWhere('o.ecoleId = :e_id')->setParameter('e_id', $ecole_id)
								   ->andWhere('o.anneeScolaireId = :a_id')->setParameter('a_id', $annee_scolaire_id);

			  return $qb->getQuery()->getResult();
			}
}