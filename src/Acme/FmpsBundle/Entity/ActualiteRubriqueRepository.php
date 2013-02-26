<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ActualiteRubriqueRepository extends EntityRepository
{
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')->select('a'); 
      
      if ($options->getTitle() && $options->getTitle() != '')
      {
          $qb->andWhere('a.title = :title')->setParameter('title', $options->getTitle()); 
      }
      
      if ($options->getDescription() && $options->getDescription() != '')
      {
          $qb->andWhere('a.description = :description')->setParameter('description', $options->getDescription());
      }
     
         
       
      return $qb->getQuery();
    }
}

?>
