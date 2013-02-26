<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EmployeRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('e') 
								 ->select('e, f, ec')
       					 ->leftJoin('e.ecole', 'ec')
       					 ->leftJoin('e.fonction', 'f');
      
      if ($options->getNom() && $options->getNom() != '')
      {
          $qb->andWhere('e.nom LIKE :nom')->setParameter('nom', '%' . $options->getNom() . '%'); 
      }
      
      if ($options->getPrenom() && $options->getPrenom() != '')
      {
          $qb->andWhere('e.prenom LIKE :prenom')->setParameter('prenom', '%' . $options->getPrenom() . '%'); 
      }
      
      if ($options->getMatricule() && $options->getMatricule() != '')
      {
          $qb->andWhere('e.matricule = :matricule')->setParameter('matricule', sprintf("%03d", $options->getMatricule())); 
      }
     
      if ($options->getTel() && $options->getTel() != '')
      {
          $qb->andWhere('e.tel = :telephone')->setParameter('telephone', $options->getTel());
      }
      
      if ($options->getFonction() && $options->getFonction() != '')
      {
          $qb->andWhere('e.fonctionId = :fonction')->setParameter('fonction', $options->getFonction());
      }

			if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('e.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole());
      }
      
      return $qb->getQuery();
    }
    
    public function getAllWithFonction()
    {
    
      $qb = $this->createQueryBuilder('em')
         ->select('em, f, s, e')
         ->addOrderBy('em.id', 'ASC')
         ->leftJoin('em.fonction', 'f')
				 ->leftJoin('em.superieur', 's')
				 ->leftJoin('em.ecole', 'e');
      
      return $qb->getQuery();
      
    }

    public function getOneWithAssociation($id)
    {
    
      $qb = $this->createQueryBuilder('em')
         ->select('em, f, s, e')
				 ->where('em.id = '.$id)
         ->leftJoin('em.fonction', 'f')
				 ->leftJoin('em.superieur', 's')
				 ->leftJoin('em.ecole', 'e')
				 ->addOrderBy('em.id', 'ASC')
				 ->setMaxResults(1);
      
      return $qb->getQuery()->getSingleResult();
      
    }

   public function deleteUser($id)
   {
      $this->_em->createQueryBuilder()
           ->delete('AcmeFmpsBundle:User', 'u')
           ->where('u.employeId = :employe_id')
           ->setParameter('employeId', $id)
           ->getQuery()
           ->execute();
   }

  public function getEmployeForSelect()
  {
	   	$qb = $this->createQueryBuilder('e')
        ->select("e.id, CONCAT( e.nom,  ' ', e.prenom ) ")
        ->addOrderBy('e.prenom, e.nom', 'ASC');

			return $qb->getQuery();
	}
	
}