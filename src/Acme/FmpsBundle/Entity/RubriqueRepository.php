<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class RubriqueRepository extends EntityRepository
{
    
    public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('r')->select('r'); 
      
      if ($options->getIntitule() && $options->getIntitule() != '')
      {
          $qb->andWhere('r.intitule LIKE :intitule')->setParameter('intitule', '%'. $options->getIntitule() . '%'); 
      }
      
      if ($options->getChapitre() && $options->getChapitre() != '')
      {
          $qb->andWhere('r.chapitre = :chapitre')->setParameter('chapitre', $options->getChapitre());
      }
     
      if ($options->getArticle() && $options->getArticle() != '')
      {
          $qb->andWhere('r.article = :article')->setParameter('article', $options->getArticle());
      }
      
      if ($options->getParagraphe() && $options->getParagraphe() != '')
      {
          $qb->andWhere('r.paragraphe = :paragraphe')->setParameter('paragraphe', $options->getParagraphe());
      }
      
      if ($options->getAmmortissable() == '0' || $options->getAmmortissable() == '1')
      {
          $qb->andWhere('r.ammortissable = :ammortissable')->setParameter('ammortissable', $options->getAmmortissable());
      }
      
      if ($options->getDureeAmmortissement() && $options->getDureeAmmortissement() != '')
      {
          $qb->andWhere('r.dureeAmmortissement = :dureeAmmortissement')->setParameter('dureeAmmortissement', $options->getDureeAmmortissement());
      }
      
      return $qb->getQuery();
    }
    
    public function getRubriquesForSelect(){
      return $this->createQueryBuilder('r')->select('r.id, r.intitule');
    }
       
}