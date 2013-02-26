<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class TypeContributionRepository extends EntityRepository
{
    
	public function findByLibelle($libelle)
    {
      return $this->findOneBy(array('libelleTypeContribution' => $libelle));
    }

    public function findOrCreateByLibelle($libelle){
        $typeContribution = $this->findByLibelle($libelle);
        if ($typeContribution == null) {
          $typeContribution = new \Acme\FmpsBundle\Entity\TypeContribution();
          $typeContribution->setLibelleTypeContribution($libelle);
          $this->_em->persist($typeContribution);
          $this->_em->flush();
        }
        return $typeContribution;
    }
}