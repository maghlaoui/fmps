<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ArticleRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('a')->select('a'); 
      
      if ($options->getDesignation() && $options->getDesignation() != '')
      {
          $qb->andWhere('a.designation LIKE :designation')->setParameter('designation', '%'. $options->getDesignation() . '%'); 
      }
      
      if ($options->getDescription() && $options->getDescription() != '')
      {
          $qb->andWhere('a.description LIKE :description')->setParameter('description', '%'. $options->getDescription() . '%');
      }
      
      return $qb->getQuery();
    }
    
    public function findByDesignation($designation)
    {
      return $this->findOneBy(array('designation' => $designation));
    }
    
    public function findOneById($id)
    {
      return $this->findOneBy(array('id' => $id));
    }
    
    public function findOrCreateByDesignation($designation){
        $article = $this->findByDesignation($designation);
        if ($article == null) {
          $article = new \Acme\FmpsBundle\Entity\Article;
          $article->setDesignation($designation);
          $this->_em->persist($article);
          $this->_em->flush();
        }
        return $article;
    }
    
}