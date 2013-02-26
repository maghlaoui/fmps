<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class UserRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('u')->select('u'); 
      
      if ($options->getUsername() && $options->getUsername() != '')
      {
          $qb->andWhere('u.username LIKE :u')->setParameter('u', '%' . $options->getUsername().'%' ); 
      }
      
      if ($options->getEmail() && $options->getEmail() != '')
      {
          $qb->andWhere('u.email = :email')->setParameter('email', $options->getEmail() );
      }
      
      return $qb->getQuery();
    }
    
}