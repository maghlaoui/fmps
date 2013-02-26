<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ContactRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('c')->select('c'); 
      
      if ($options->getNomContact() && $options->getNomContact() != '')
      {
          $qb->andWhere('c.nomContact LIKE :nom')->setParameter('nom', '%'. $options->getNomContact() . '%'); 
      }
      
      if ($options->getPrenomContact() && $options->getPrenomContact() != '')
      {
          $qb->andWhere('c.prenomContact LIKE :prenom')->setParameter('prenom', '%'. $options->getPrenomContact() . '%'); 
      }
     
      if ($options->getMailContact() && $options->getMailContact() != '')
      {
          $qb->andWhere('c.mailContact = :email')->setParameter('email', $options->getMailContact());
      }
      
      if ($options->getStatusContact() && $options->getStatusContact() != '')
      {
          $qb->andWhere('c.statusContact = :status')->setParameter('status', $options->getStatusContact());
      }
      
      return $qb->getQuery();
    }
       
}