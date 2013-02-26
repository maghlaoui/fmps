<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class PartenaireRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('p')->select('p');
      
      if ($options->getNomPartenaire() && $options->getNomPartenaire() != '')
      {
          $qb->andWhere('p.nomPartenaire LIKE :nom')->setParameter('nom', '%' . $options->getNomPartenaire() . '%'); 
      }
      
      if ($options->getAdressePartenaire() && $options->getAdressePartenaire() != '')
      {
          $qb->andWhere('p.adressePartenaire LIKE :adresse')->setParameter('adresse', '%' . $options->getAdressePartenaire() . '%');
      }
     
      if ($options->getTel1Partenaire() && $options->getTel1Partenaire() != '')
      {
          $qb->andWhere('p.tel1Partenaire = :telephone')->setParameter('telephone', $options->getTel1Partenaire());
      }
      
      if ($options->getMailPartenaire() && $options->getMailPartenaire() != '')
      {
          $qb->andWhere('p.mailPartenaire = :mail')->setParameter('mail', $options->getMailPartenaire());
      }
      
      if ($options->getVille() && $options->getVille() != '')
      {
          $qb->andWhere('p.villeId = :ville')->setParameter('ville', $options->getVille());
      }
      
      return $qb->getQuery();
    }
    
}