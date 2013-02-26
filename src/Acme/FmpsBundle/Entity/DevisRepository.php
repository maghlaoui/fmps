<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class DevisRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('d')->select('d'); 
      
      if ($options->getBonCommande() && $options->getBonCommande() != '')
      {
          $qb->andWhere('d.bonCommandeId = :bc_id')->setParameter('bc_id', $options->getBonCommande()); 
      }
      
      return $qb->getQuery();
    }
    
}