<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ClasseRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('c')
								 ->select('c, e, s, a')
         				 ->leftJoin('c.ecole', 'e')
								 ->leftJoin('c.section', 's')
         				 ->leftJoin('c.anneeScolaire', 'a');

			$ecoles = $user->getEcoles();
     
			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
      {
          $qb->andWhere($qb->expr()->in('c.ecoleId', $ecoles));
      } 
      
			if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('c.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getSection() && $options->getSection() != '')
      {
          $qb->andWhere('c.sectionId = :sec_id')->setParameter('sec_id', $options->getSection()); 
      }

			if ($options->getNomClasse() && $options->getNomClasse() != '')
      {
          $qb->andWhere('c.nomClasse = :nom')->setParameter('nom', $options->getNomClasse()); 
      }

			if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('c.anneeScolaire = :as')->setParameter('as', $options->getAnneeScolaire()); 
      }
      
      return $qb->getQuery();
    }
       
}