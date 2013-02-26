<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class TypeEngagementRepository extends EntityRepository
{
	public function findByLibelle($libelle)
    {
      return $this->findOneBy(array('libelleTypeEngagement' => $libelle));
    }

    public function findOrCreateByLibelle($libelle){
        $typeEngagement = $this->findByLibelle($libelle);
        if ($typeEngagement == null) {
          $typeEngagement = new \Acme\FmpsBundle\Entity\TypeEngagement();
          $typeEngagement->setLibelleTypeEngagement($libelle);
          $this->_em->persist($typeEngagement);
          $this->_em->flush();
        }
        return $typeEngagement;
    }
	
}