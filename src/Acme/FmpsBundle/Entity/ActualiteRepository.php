<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ActualiteRepository extends EntityRepository
{
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')
								 ->select('a, r')
       					 ->leftJoin('a.rubrique', 'r'); 
      
      if ($options->getRubrique() && $options->getRubrique() != '')
      {
          $qb->andWhere('a.rubrique = :rubrique')->setParameter('rubrique', $options->getRubrique()); 
      }
      
      if ($options->getTitle() && $options->getTitle() != '')
      {
          $qb->andWhere('a.title = :title')->setParameter('title', $options->getTitle());
      }
     
      if ($options->getContent() && $options->getContent() != '')
      {
          $qb->andWhere('a.content = :content')->setParameter('content', $options->getContent());
      }
       
      return $qb->getQuery();
    }

    public function findAllWithRubriques()
    {
	    
	   $qb = $this->createQueryBuilder('a')
								->select('a, r')
								->leftJoin('a.rubrique', 'r')
								->orderBy('r.createdAt', 'DESC');
								
		return $qb->getQuery()->getFirstResult();
    }
}

?>
