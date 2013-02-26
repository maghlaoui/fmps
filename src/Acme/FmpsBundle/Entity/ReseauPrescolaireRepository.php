<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ReseauPrescolaireRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('r')->select('r, p')
       ->leftJoin('r.partenariat', 'p');
      
      if ($options->getPartenariat() && $options->getPartenariat() != '')
      {
          $qb->andWhere('r.partenariatId = :p_id')->setParameter('p_id', $options->getPartenariat()); 
      }

			if ($options->getLibelleReseauPrescolaire() && $options->getLibelleReseauPrescolaire() != '')
      {
          $qb->andWhere('r.libelleReseauPrescolaire = :libelle')->setParameter('libelle', $options->getLibelleReseauPrescolaire()); 
      }
      
      return $qb->getQuery();
    }
       
}