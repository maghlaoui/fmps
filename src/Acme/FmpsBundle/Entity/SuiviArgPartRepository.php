<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class SuiviArgPartRepository extends EntityRepository
{
    
   public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('s')
          ->select('s, p')
          ->leftJoin('s.partenariatPartenaire', 'p')  
          ->orderBy('s.updatedAt', 'desc');

      
      if ($options->getPartenariatPartenaire() && $options->getPartenariatPartenaire() != '')
      {
          $qb->andWhere('s.partenariatPartenaireId = :p_id')->setParameter('p_id', $options->getPartenariatPartenaire()); 
      }
     
      if ($options->getMontant() && $options->getMontant() != '')
      {
          $qb->andWhere('s.montant = :montant')->setParameter('montant', $options->getMontant());
      }
      
      if ($options->getDateReception() && $options->getDateReception() != '')
      {
          $qb->andWhere('s.dateReception = :reception')->setParameter('reception', $options->getDateReception());
      }
      
      return $qb->getQuery();
    }

	public function getContributions($partenariatId)
	   {
		  $qb = $this->createQueryBuilder('c')
	          ->select('c')
	          ->leftJoin('c.partenariatPartenaire', 'p')
			      ->andWhere('p.partenariatId = :partenariat_id')
			      ->setParameter('partenariat_id', $partenariatId)
	          ->orderBy('c.dateReception', 'desc');
	
		  return $qb->getQuery()->getResult();
	   }
       
}