<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EcoleCaisseRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user)
    {

      $qb = $this->_em->createQueryBuilder()
											->select('e, c, e.nom, c.id, c.numeroCompte, e.id AS ecoleId')
											->from('Acme\FmpsBundle\Entity\Ecole', 'e')
											->leftJoin('e.caisses', 'c')
											->andWhere('e.id  > 1');
											
		  $ecoles = $user->getEcoles();

			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
		  {
					$qb->andWhere($qb->expr()->in('e.id', $ecoles));
			}
			
      if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('c.ecoleId = :id')->setParameter('id', $options->getEcole() ); 
      }
      
      if ($options->getNumeroCompte() && $options->getNumeroCompte() != '')
      {
          $qb->andWhere('c.numeroCompte = :num')->setParameter('num', $options->getNumeroCompte() );
      }
      
      return $qb->getQuery();
    }

  public function getCountByEcole()
   {
	   	$query = $this->_em->createQuery('SELECT COUNT(e.id) FROM AcmeFmpsBundle:Ecole e WHERE e.id != 1 AND e.id NOT IN (SELECT c.ecoleId FROM AcmeFmpsBundle:EcoleCaisse c)');
			$count = $query->getSingleScalarResult();
			return $count;
   }

	public function findAllWithEcole()
   {
	   	return $this->_em->createQuery('SELECT e, c, e.nom, c.id, c.numeroCompte, e.id AS ecoleId FROM Acme\FmpsBundle\Entity\Ecole e LEFT JOIN e.caisses c WHERE e.id != 1');
   }


    
}