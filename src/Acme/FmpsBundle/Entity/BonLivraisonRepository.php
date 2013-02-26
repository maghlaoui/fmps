<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class BonLivraisonRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('b')->select('b'); 
      
      if ($options->getBonCommande() && $options->getBonCommande() != '')
      {
          $qb->andWhere('b.bonCommandeId = :bc_id')->setParameter('bc_id', $options->getBonCommande()); 
      }
      
      return $qb->getQuery();
    }
    
}