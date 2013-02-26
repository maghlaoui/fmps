<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class BonCommandeRepository extends EntityRepository
{
    
	public function getAllWithFournisseur($anneeBc = null, $status = null)
    {
    
      $qb = $this->createQueryBuilder('b')
         ->select('b')
         ->addOrderBy('b.anneeBc, b.numero', 'ASC')
         ->leftJoin('b.fournisseur', 'f');
      
      if ($status && $status != '')
      {
          $qb->andWhere('b.status = :status')->setParameter('status', $status);
      }
     
      if ($anneeBc && $anneeBc != '')
      {
          $qb->andWhere('b.anneeBc = :annee')->setParameter('annee', $anneeBc);
      }
      
      return $qb->getQuery();
      
    }
    
   public function getOneWithFournisseurAndRubrique($id)
    {
    
      $qb = $this->createQueryBuilder('b')
         ->select('b')
         ->andWhere('b.id = :b_id')
         ->setParameter('b_id', $id)
         ->leftJoin('b.fournisseur', 'fournisseur')
         ->leftJoin('b.rubrique', 'rubrique'); 
      
      return $qb->getQuery()->getFirstResult();
      
    }
    
   public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('b')
          ->select('b, f')
          ->leftJoin('b.fournisseur', 'f')
          ->orderBy('b.numero', 'ASC');

      
      if ($options->getFournisseur() && $options->getFournisseur() != '')
      {
          $qb->andWhere('b.fournisseurId = :f_id')->setParameter('f_id', $options->getFournisseur()); 
      }
      
      if ($options->getStatus() && $options->getStatus() != '')
      {
          $qb->andWhere('b.status = :status')->setParameter('status', $options->getStatus());
      }
     
      if ($options->getAnneeBc() && $options->getAnneeBc() != '')
      {
          $qb->andWhere('b.anneeBc = :annee')->setParameter('annee', $options->getAnneeBc());
      }
      
      if ($options->getDateBc() && $options->getDateBc() != '' && $options->getUpdatedAt() && $options->getUpdatedAt() != '')
      {
          $qb->andWhere('b.dateBc BETWEEN :from_date AND :to_date')
			    ->setParameter('from_date', $options->getDateBc())->setParameter('to_date', $options->getUpdatedAt());
      }
      
      return $qb->getQuery();
    }
    
    public function getCountByFournisseurId($id){
        return $this->createQueryBuilder('b')
		   ->select('COUNT(b.id)')
           ->andWhere('b.fournisseurId = :f_id')
           ->setParameter('f_id', $id)
           ->getQuery()
           ->getSingleScalarResult(); 
    }
    
    public function getCountByRubriqueId($id){
        return $this->createQueryBuilder('b')
					->select('COUNT(b.id)')
           			->andWhere('b.rubriqueId = :r_id')
           			->setParameter('r_id', $id)
           			->getQuery()
                ->getSingleScalarResult(); 
    }
    
    public function deleteFacture($id){
        $this->_em->createQueryBuilder()->delete('AcmeFmpsBundle:Facture', 'f')
				  ->where('f.bonCommandeId = :bc_id')
				  ->setParameter('bc_id', $id)
				  ->getQuery()
				  ->execute();
    }

    public function getGroupedStatsByYear(){
        $qb = $this->createQueryBuilder('b')->select('b.anneeBc , b.status , sum( b.montant ) AS total')
           ->andWhere("b.status IN ('engagé', 'payé')")
           ->addGroupBy('b.anneeBc, b.status')
           ->addOrderBy('b.anneeBc, b.status', 'ASC')
           ->getQuery();
        return $qb->getResult(); 
    }
       
}