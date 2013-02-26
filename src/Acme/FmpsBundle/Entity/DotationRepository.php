<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class DotationRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('d')
					->select('d, e')
					->leftJoin('d.ecole', 'e')
					->orderBy('d.createdAt', 'ASC');
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('d.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }
      
      if ($options->getAnnee() && $options->getAnnee() != '')
      {
          $qb->andWhere('d.annee = :annee')->setParameter('annee', $options->getAnnee());
      }
     
      if ($options->getPeriode() && $options->getPeriode() != '')
      {
          $qb->andWhere('d.periode = :periode')->setParameter('periode', $options->getPeriode());
      }
      
      if ($options->getMontant() && $options->getMontant() != '')
      {
          $qb->andWhere('d.montant = :montant')->setParameter('montant', $options->getMontant());
      }
      
      return $qb->getQuery();
    }
       
}