<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EnfantRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user)
    {

      $qb = $this->createQueryBuilder('e')
 								 ->select('e, ec')
                 ->leftJoin('e.ecole', 'ec')
								 ->leftJoin('e.inscriptions', 'i');


			$ecoles = $user->getEcoles();
    
			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
      {
         $qb->andWhere($qb->expr()->in('i.ecoleId', $ecoles));
      }
     
      if ($options->getNom() && $options->getNom() != '')
      {
          $qb->andWhere('e.nom LIKE :nom')->setParameter('nom', '%' . $options->getNom() . '%');
      }

			if ($options->getPrenom() && $options->getPrenom() != '')
      {
          $qb->andWhere('e.prenom LIKE :prenom')->setParameter('prenom', '%' . $options->getPrenom() . '%');
      }
      
      if ($options->getDateNaissance() && $options->getDateNaissance() != '')
      {
          $qb->andWhere('e.dateNaissance = :dateNaissance')->setParameter('dateNaissance', $options->getDateNaissance());
      }

			if ($options->getSexe() && $options->getSexe() != '')
      {
          $qb->andWhere('e.sexe = :sexe')->setParameter('sexe', $options->getSexe());
      }
      
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('e.ecoleId = :ecole')->setParameter('ecole', $options->getEcole());
      }
      
      return $qb->getQuery();
    }
    
}