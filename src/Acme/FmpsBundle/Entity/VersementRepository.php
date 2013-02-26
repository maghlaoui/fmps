<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class VersementRepository extends EntityRepository
{
	public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('v')->select('v'); 
     
      if ($options->getPersonnePaiement() && $options->getPersonnePaiement() != '')
      {
          $qb->andWhere('v.personnePaiement LIKE :nom')->setParameter('nom', '%' . $options->getPersonnePaiement() . '%');
      }

			if ($options->getDateOperation() && $options->getDateOperation() != '')
      {
          $qb->andWhere('v.dateOperation = :dateOperation')->setParameter('dateOperation', $options->getDateOperation() );
      }

			if ($options->getDateValeur() && $options->getDateValeur() != '')
      {
          $qb->andWhere('v.dateValeur = :dateValeur')->setParameter('dateValeur', $options->getDateValeur() );
      }
      
      if ($options->getRefVirement() && $options->getRefVirement() != '')
      {
          $qb->andWhere('v.refVirement = :ref')->setParameter('ref', $options->getRefVirement());
      }
      
      return $qb->getQuery();
    }
	
}