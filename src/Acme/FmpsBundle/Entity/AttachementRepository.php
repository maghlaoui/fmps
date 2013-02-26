<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AttachementRepository extends EntityRepository
{
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')->select('a'); 
      
      if ($options->getActualite() && $options->getActualite() != '')
      {
          $qb->andWhere('a.actualite = :actualite')->setParameter('actualite', $options->getActualite()); 
      }
      
      
      return $qb->getQuery();
    }
}

?>

