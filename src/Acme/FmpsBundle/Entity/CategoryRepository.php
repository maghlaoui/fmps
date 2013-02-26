<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class CategoryRepository extends EntityRepository
{
	public function findByLibelle($libelle)
    {
      return $this->findOneBy(array('libelle' => $libelle));
    }

    public function findOrCreateByLibelle($libelle){
        $category = $this->findByLibelle($libelle);
        if ($category == null) {
          $category = new \Acme\FmpsBundle\Entity\Category();
          $category->setLibelleTypeEngagement($libelle);
          $this->_em->persist($category);
          $this->_em->flush();
        }

        return $category;
    }
	
}