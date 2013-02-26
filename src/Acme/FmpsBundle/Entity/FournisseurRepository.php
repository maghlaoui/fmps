<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class FournisseurRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('f')->select('f'); 
      
      if ($options->getNom() && $options->getNom() != '')
      {
          $qb->andWhere('f.nom LIKE :nom')->setParameter('nom', '%' . $options->getNom() . '%'); 
      }
      
      if ($options->getAdresse() && $options->getAdresse() != '')
      {
          $qb->andWhere('f.adresse LIKE :adresse')->setParameter('adresse', '%' . $options->getAdresse() . '%');
      }
     
      if ($options->getTelephone() && $options->getTelephone() != '')
      {
          $qb->andWhere('f.telephone = :telephone')->setParameter('telephone', $options->getTelephone());
      }
      
      if ($options->getRegistreCommerce() && $options->getRegistreCommerce() != '')
      {
          $qb->andWhere('f.registreCommerce = :rc')->setParameter('rc', $options->getRegistreCommerce());
      }
      
      if ($options->getNumeroPatente() && $options->getNumeroPatente() != '')
      {
          $qb->andWhere('f.numeroPatente = :np')->setParameter('np', $options->getNumeroPatente());
      }
      
      if ($options->getIdentifiantFiscale() && $options->getIdentifiantFiscale() != '')
      {
          $qb->andWhere('f.identifiantFiscale = :if')->setParameter('if', $options->getIdentifiantFiscale());
      }
      
      return $qb->getQuery();
    }
    
    public function getFournisseursForSelect(){
      $qb = $this->createQueryBuilder('f')->select('f.id, f.nom')->addOrderBy('f.nom', 'ASC')->getQuery();
	  return $qb->getArrayResult();
    }
    
}