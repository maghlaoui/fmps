<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class PaiementRepository extends EntityRepository
{

    
   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('p')->select('p');
      
      if ($options->getMatricule() && $options->getMatricule() != '')
      {
          $qb->andWhere('p.matricule = :matricule')->setParameter('matricule', $options->getMatricule() ); 
      }
      
      if ($options->getInscription() && $options->getInscription() != '')
      {
          $qb->andWhere('p.inscriptionId = :i_id')->setParameter('i_id', $options->getInscription());
      }
     
      if ($options->getNomPersonnePaiement() && $options->getNomPersonnePaiement() != '')
      {
          $qb->andWhere('p.nomPersonnePaiement = :nom')->setParameter('nom', $options->getNomPersonnePaiement());
      }
      
      if ($options->getMoyenPaiement() && $options->getMoyenPaiement() != '')
      {
          $qb->andWhere('p.moyenPaiement = :moyen')->setParameter('moyen', $options->getMoyenPaiement());
      }
      
      return $qb->getQuery();
    }
    
}