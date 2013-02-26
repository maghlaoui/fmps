<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class DocumentRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('d')
								 ->select('d, partenariat, type_document') 
		   					 ->leftJoin('d.partenariat', 'partenariat')
	     					 ->leftJoin('d.type_document', 'type_document');
     
      if ($options->getPartenariat() && $options->getPartenariat() != '')
      {
          $qb->andWhere('d.partenariatId = :partenariat')->setParameter('partenariat', $options->getPartenariat());
      }
      
      if ($options->getTypeDocument() && $options->getTypeDocument() != '')
      {
          $qb->andWhere('d.typeDocumentId = :type')->setParameter('type', $options->getTypeDocument());
      }
      
      return $qb->getQuery();
    }
    
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }
    
}