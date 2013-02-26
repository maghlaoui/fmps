<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class InscriptionOffreServiceRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('i')->select('i'); 
      
      if ($options->getInscription() && $options->getInscription() != '')
      {
          $qb->andWhere('i.inscriptionId = :i_id')->setParameter('i_id', $options->getInscription() ); 
      }
      
      if ($options->getOffreService() && $options->getOffreService() != '')
      {
          $qb->andWhere('i.offreServiceId = :os_id')->setParameter('os_id', $options->getOffreService() ); 
      }

      if ($options->getMois() && $options->getMois() != '')
      {
          $qb->andWhere('i.mois = :mois')->setParameter('mois', $options->getMois());
      }
      
      return $qb->getQuery();
    }
    
}