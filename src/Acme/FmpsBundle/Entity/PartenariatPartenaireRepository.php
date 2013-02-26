<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class PartenariatPartenaireRepository extends EntityRepository
{

   public function findBySearchCriteria($options)
    {

      $qb = $this->createQueryBuilder('p')
		   ->select('p, partenaire, partenariat')
		   ->leftJoin('p.partenaire', 'partenaire')
	     ->leftJoin('p.partenariat', 'partenariat'); 
      
      if ($options->getPartenariat() && $options->getPartenariat() != '')
      {
          $qb->andWhere('p.partenariatId = :partenariat')->setParameter('partenariat', $options->getPartenariat() ); 
      }
      
      if ($options->getPartenaire() && $options->getPartenaire() != '')
      {
          $qb->andWhere('p.partenaireId = :partenaire')->setParameter('partenaire', $options->getPartenaire() );
      }
     
      if ($options->getTypeEngagement() && $options->getTypeEngagement() != '')
      {
          $qb->andWhere('p.typeEngagementId = :engagement')->setParameter('engagement', $options->getTypeEngagement());
      }
      
      if ($options->getTypeContribution() && $options->getTypeContribution() != '')
      {
          $qb->andWhere('p.typeContributionId = :contribution')->setParameter('contribution', $options->getTypeContribution());
      }
      
      if ($options->getMontantParticipation() && $options->getMontantParticipation() != '')
      {
          $qb->andWhere('p.montantParticipation = :montant')->setParameter('montant', $options->getMontantParticipation());
      }
      
      return $qb->getQuery();
    }

	public function getPartenariatsDetails()
	 {
		return $this->createQueryBuilder('p')
	       ->select('p, pr, pt, tc, te')
	       ->leftJoin('p.partenaire', 'pr')
	       ->leftJoin('p.partenariat', 'pt')
		     ->leftJoin('p.type_contribution', 'tc')
		     ->leftJoin('p.type_engagement', 'te')
	       ->getQuery();
	 }
    
}