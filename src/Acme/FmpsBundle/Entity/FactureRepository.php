<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class FactureRepository extends EntityRepository
{

   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('f')->select('f'); 
      
      if ($options->getNumero() && $options->getNumero() != '')
      {
          $qb->andWhere('f.numero = :numero')->setParameter('numero', $options->getNumero()); 
      }
      
      if ($options->getEtat() && $options->getEtat() != '')
      {
          $qb->andWhere('f.etat = :etat')->setParameter('etat', $options->getEtat()); 
      }
      
      if ($options->getDatePaiement() && $options->getDatePaiement() != '')
      {
          $qb->andWhere('f.datePaiement = :datePaiement')->setParameter('datePaiement', $options->getDatePaiement());
      }
     
      if ($options->getDatePrevisionPaiement() && $options->getDatePrevisionPaiement() != '')
      {
          $qb->andWhere('f.datePrevisionPaiement = :dpp')->setParameter('dpp', $options->getDatePrevisionPaiement());
      }
      
      if ($options->getTypePaiement() && $options->getTypePaiement() != '')
      {
          $qb->andWhere('f.typePaiement = :tp')->setParameter('tp', $options->getTypePaiement());
      }
      
      if ($options->getBonCommande() && $options->getBonCommande() != '')
      {
          $qb->andWhere('f.bonCommandeId = :bc')->setParameter('bc', $options->getBonCommande());
      }
      
      return $qb->getQuery();
    }

    public function getOneByBonCommandeId($id){
        $qb = $this->createQueryBuilder('f')->select('f');
        return $qb->andWhere('f.bonCommandeId = :bc_id')
           ->setParameter('bc_id', $id)
           ->getQuery()
           ->getOneOrNullResult();
    }
    
}