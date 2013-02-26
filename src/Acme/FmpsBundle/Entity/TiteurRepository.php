<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class TiteurRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('t')->select('t'); 
     
      if ($options->getNom() && $options->getNom() != '')
      {
          $qb->andWhere('t.nom LIKE :nom')->setParameter('nom', '%' . $options->getNom() . '%');
      }

			if ($options->getPrenom() && $options->getPrenom() != '')
      {
          $qb->andWhere('t.prenom LIKE :prenom')->setParameter('prenom', '%' . $options->getPrenom() . '%');
      }

			if ($options->getCin() && $options->getCin() != '')
      {
          $qb->andWhere('t.cin = :cin')->setParameter('cin', $options->getCin() );
      }

			if ($options->getProfession() && $options->getProfession() != '')
      {
          $qb->andWhere('t.profession = :profession')->setParameter('profession', $options->getProfession() );
      }
      
      if ($options->getVille() && $options->getVille() != '')
      {
          $qb->andWhere('t.villeId = :ville')->setParameter('ville', $options->getVille());
      }
      
      return $qb->getQuery();
    }
    
}