<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class AbandantRepository extends EntityRepository
{
    
	public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')
          ->select('a, ec, em')
          ->leftJoin('a.ecole', 'ec')
		      ->leftJoin('a.employe', 'em')
          ->orderBy('a.id', 'desc');

      
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
}