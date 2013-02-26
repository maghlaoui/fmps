<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class InscriptionRepository extends EntityRepository
{

   public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('i')->select('i'); 
      $ecoles = $user->getEcoles();
     
			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
      {
          $qb->andWhere($qb->expr()->in('i.ecoleId', $ecoles));
      }

      if ($options->getNumDemande() && $options->getNumDemande() != '')
      {
          $qb->andWhere('i.numDemande = :numDemande')->setParameter('numDemande', $options->getNumDemande()); 
      }
      
      if ($options->getDateDemande() && $options->getDateDemande() != '')
      {
          $qb->andWhere('i.dateDemande = :date_d')->setParameter('date_d', $options->getDateDemande());
      }
     
      if ($options->getTypeDemande() && $options->getTypeDemande() != '')
      {
          $qb->andWhere('i.typeDemande = :type_d')->setParameter('type_d', $options->getTypeDemande());
      }
      
      if ($options->getEtatDemande() && $options->getEtatDemande() != '')
      {
          $qb->andWhere('i.etatDemande = :etat_d')->setParameter('etat_d', $options->getEtatDemande());
      }

			if ($options->getAnneeScolaire() && $options->getAnneeScolaire() != '')
      {
          $qb->andWhere('i.anneeScolaireId = :as_id')->setParameter('as_id', $options->getAnneeScolaire()); 
      }

			if ($options->getSection() && $options->getSection() != '')
      {
          $qb->andWhere('i.sectionId = :section_id')->setParameter('section_id', $options->getSection()); 
      }

			if ($options->getEcole() && $options->getEcole() != '')
      {
          $qb->andWhere('i.ecoleId = :ecole_id')->setParameter('ecole_id', $options->getEcole()); 
      }

			if ($options->getTiteur() && $options->getTiteur() != '')
      {
          $qb->andWhere('i.titeurId = :titeur_id')->setParameter('titeur_id', $options->getTiteur()); 
      }

			if ($options->getEnfant() && $options->getEnfant() != '')
      {
          $qb->andWhere('i.enfantId = :enfant_id')->setParameter('enfant_id', $options->getEnfant()); 
      }
      
      return $qb->getQuery();
    }
    
}