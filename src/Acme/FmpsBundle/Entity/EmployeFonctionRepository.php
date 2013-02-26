<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EmployeFonctionRepository extends EntityRepository
{
    
	public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('ef')
          ->select('ef, f, e')
          ->leftJoin('ef.fonction', 'f')
		  		->leftJoin('ef.employe', 'e')
          ->orderBy('ef.id', 'desc');

      
      if ($options->getFonction() && $options->getFonction() != '')
      {
          $qb->andWhere('ef.fonctionId = :fonction_id')->setParameter('fonction_id', $options->getFonction()); 
      }
      
      if ($options->getDateDebutFonction() && $options->getDateDebutFonction() != '')
      {
          $qb->andWhere('ef.dateDebutFonction = :date_debut')->setParameter('date_debut', $options->getDateDebutFonction());
      }
     
      if ($options->getDateFinFonction() && $options->getDateFinFonction() != '')
      {
          $qb->andWhere('ef.dateFinFonction = :date_fin')->setParameter('date_fin', $options->getDateFinFonction());
      }
      
      return $qb->getQuery();
    }
}