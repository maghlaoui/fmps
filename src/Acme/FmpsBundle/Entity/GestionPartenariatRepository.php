<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class GestionPartenariatRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('g')->select('g'); 
      
      if ($options->getPartenariat() && $options->getPartenariat() != '')
      {
          $qb->andWhere('g.partenariatId = :partenariat')->setParameter('partenariat', $options->getPartenariat()); 
      }
      
      if ($options->getDateAffectationGestion() && $options->getDateAffectationGestion() != '')
      {
          $qb->andWhere('g.dateAffectationGestion = :debut')->setParameter('debut', $options->getDateAffectationGestion());
      }
      
      if ($options->getDateFinAffectationGestion() && $options->getDateFinAffectationGestion() != '')
      {
          $qb->andWhere('g.dateFinAffectationGestion = :fin')->setParameter('fin', $options->getDateFinAffectationGestion());
      }
     
      if ($options->getContact() && $options->getContact() != '')
      {
          $qb->andWhere('g.contactId = :contact')->setParameter('contact', $options->getContact());
      }
      
      return $qb->getQuery();
    }
    
    
}