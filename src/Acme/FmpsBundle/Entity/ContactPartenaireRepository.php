<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ContactPartenaireRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('c')->select('c');
      
      if ($options->getPartenaire() && $options->getPartenaire() != '')
      {
          $qb->andWhere('c.partenaireId = :partenaire_id')->setParameter('partenaire_id', $options->getPartenaire()); 
      }
      
      if ($options->getContact() && $options->getContact() != '')
      {
          $qb->andWhere('c.contactId = :contact_id')->setParameter('contact_id', $options->getContact());
      }
      
      return $qb->getQuery();
    }
       
}