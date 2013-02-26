<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class VilleRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('v')->select('v');
      
      if ($options->getLibelleVille() && $options->getLibelleVille() != '')
      {
          $qb->andWhere('v.libelleVille LIKE :libelle')->setParameter('libelle', '%'. $options->getLibelleVille() . '%'); 
      }
      
      return $qb->getQuery();
    }
    
    public function findByLibelleVille($libelle){
      return $this->findOneBy(array('libelleVille' => $libelle));
    }
       
}