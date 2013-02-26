<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class PartenariatRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('p')->select('p'); 
      
      if ($options->getLibellePartenariat() && $options->getLibellePartenariat() != '')
      {
          $qb->andWhere('p.libellePartenariat LIKE :libelle')->setParameter('libelle', '%' . $options->getLibellePartenariat() . '%'); 
      }
      
      if ($options->getObjetPartenariat() && $options->getObjetPartenariat() != '')
      {
          $qb->andWhere('p.objetPartenariat LIKE :objet')->setParameter('objet', '%' . $options->getObjetPartenariat() . '%');
      }
     
      if ($options->getDatePatenariat() && $options->getDatePatenariat() != '')
      {
          $qb->andWhere('p.datePatenariat = :debut')->setParameter('debut', $options->getDatePatenariat());
      }
      
      if ($options->getDateFinPartenariat() && $options->getDateFinPartenariat() != '')
      {
          $qb->andWhere('p.dateFinPartenariat = :fin')->setParameter('fin', $options->getDateFinPartenariat());
      }
      
      return $qb->getQuery();
    }
    
}