<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class PreinscriptionRepository extends EntityRepository
{

   public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('p')
								 ->select('p, e, s, c, a')
         				 ->leftJoin('p.ecole', 'e')
								 ->leftJoin('p.section', 's')
								 ->leftJoin('p.anneeScolaire', 'a')
         				 ->leftJoin('p.category', 'c'); 
      

			$ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
			{
				 $qb->andWhere($qb->expr()->in('p.ecoleId', $ecoles));
		  }
				
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('p.ecoleId = :e_id')->setParameter('e_id', $options->getEcole() ); 
      }

      if ($options->getSection() && $options->getSection() != '')
      {
          $qb->andWhere('p.sectionId = :s_id')->setParameter('s_id', $options->getSection() ); 
      }

      if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('p.anneeScolaireId = :a_id')->setParameter('a_id', $options->getAnneeScolaire() ); 
      }
      
      if ($options->getCategory() && $options->getCategory() != '')
      {
          $qb->andWhere('p.categoryId = :c_id')->setParameter('c_id', $options->getCategory() ); 
      }

      if ($options->getNomEnfant() && $options->getNomEnfant() != '')
      {
          $qb->andWhere('p.nomEnfant LIKE :nom_e')->setParameter('nom_e', '%'.$options->getNomEnfant().'%');
      }

			if ($options->getNomTiteur() && $options->getNomTiteur() != '')
      {
          $qb->andWhere('p.nomTiteur LIKE :nom_t')->setParameter('nom_t', '%'.$options->getNomTiteur().'%');
      }
      
      return $qb->getQuery();
    }
    
}