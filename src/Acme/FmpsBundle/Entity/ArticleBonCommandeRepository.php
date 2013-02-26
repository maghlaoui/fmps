<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ArticleBonCommandeRepository extends EntityRepository
{
    
	public function getArticles(BonCommande $entity)
    {
    
      $qb = $this->createQueryBuilder('b')->select('b, a');
      
      $qb->andWhere('b.bonCommandeId = :bc_id')
    		 ->addOrderBy('b.createdAt', 'ASC')
         ->innerJoin('b.article', 'a')
    		 ->setParameter('bc_id', $entity->getId()); 
      
      return $qb->getQuery()->getResult();
      
    }
    
    public function getTotalBonCommande($id){
        
        $qb = $this->createQueryBuilder('ab')->select('SUM((ab.quantite * ab.prixUnitaire)*(1+(ab.tva/100)))');
      
        $qb->andWhere('ab.bonCommandeId = :bc_id')
           ->innerJoin('ab.article', 'a')
    		   ->setParameter('bc_id', $id); 
      
      return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function getArticlesGroupedByTva(BonCommande $entity)
    {
    
      $qb = $this->createQueryBuilder('b')->select('b.tva, SUM((b.quantite * b.prixUnitaire)*(b.tva/100))');
      
      $qb->andWhere('b.bonCommandeId = :bc_id')
         ->addOrderBy('b.tva', 'DESC')
    		 ->addGroupBy('b.tva')
         ->innerJoin('b.article', 'a')
    		 ->setParameter('bc_id', $entity->getId()); 
      
      return $qb->getQuery()->getResult();
      
    }
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')
          ->select('a')
          ->leftJoin('a.bonCommande', 'bonCommande')
          ->leftJoin('a.article', 'article')
          ->leftJoin('a.user', 'user')
          ->orderBy('a.updatedAt', 'desc');

      
      if ($options->getBonCommande() && $options->getBonCommande() != '')
      {
          $qb->andWhere('a.bonCommandeId = :bc_id')->setParameter('bc_id', $options->getBonCommande());
      }
      
      if ($options->getArticle() && $options->getArticle() != '')
      {
          $qb->andWhere('a.articleId = :article')->setParameter('article', $options->getArticle());
      }
     
      if ($options->getUser() && $options->getUser() != '')
      {
          $qb->andWhere('a.userId = :user')->setParameter('user', $options->getUser());
      }
      
      return $qb->getQuery();
    }
    
    public function updateBonComandeTotal($id){
      $montant = $this->_em->getRepository('AcmeFmpsBundle:ArticleBonCommande')->getTotalBonCommande($id);
      return $this->_em->createQueryBuilder()
      ->update('AcmeFmpsBundle:BonCommande', 'b')
      ->where('b.id = :filter')
      ->setParameter('filter', $id)
      ->set('b.montant', $montant)
      ->getQuery()
      ->execute();
    }

	public function findAllForImmobilisation($options)
    {

      $qb = $this->createQueryBuilder('ab')
          ->select('ab, b, a, r')
          ->leftJoin('ab.bonCommande', 'b')
          ->leftJoin('ab.article', 'a')
		      ->leftJoin('b.rubrique', 'r')
		      ->andWhere('r.ammortissable = 1')
          ->orderBy('r.id, b.anneeBc', 'desc');

      
      if (isset($options['bonCommande']) && $options['bonCommande'] != '')
      {
          $qb->andWhere('ab.bonCommandeId = :bc_id')->setParameter('bc_id', $options['bonCommande']); 
      }
      
      if (isset($options['article']) && $options['article'] != '')
      {
          $qb->andWhere('ab.articleId = :article')->setParameter('article', $options['article']);
      }

	    if (isset($options['rubrique']) && $options['rubrique'] != '')
      {
          $qb->andWhere('b.rubriqueId = :rubrique')->setParameter('rubrique', $options['rubrique']);
      }

	    if (isset($options['affectation']) && $options['affectation'] != '')
      {
          $qb->andWhere('b.affectation = :affectation')->setParameter('affectation', $options['affectation']);
      }

	    if (isset($options['dateBc']) && $options['dateBc'] != '')
      {
          $qb->andWhere('b.dateBc = :dateBc')->setParameter('dateBc', $options['dateBc']);
      }
     
      return $qb->getQuery();
    }
   
    public function findImmobilisationForStats()
    {

      $qb = $this->createQueryBuilder('ab')
          ->select('b.anneeBc, r.intitule, r.id, SUM((ab.quantite * ab.prixUnitaire)*(1+(ab.tva/100))) AS totalAnnee')
          ->leftJoin('ab.bonCommande', 'b')
          ->leftJoin('ab.article', 'a')
		      ->leftJoin('b.rubrique', 'r')
		      ->andWhere('r.ammortissable = 1')
		      ->groupBy('b.anneeBc, r.intitule')
          ->orderBy('b.anneeBc', 'desc');


      return $qb->getQuery()->getResult();
    }
}