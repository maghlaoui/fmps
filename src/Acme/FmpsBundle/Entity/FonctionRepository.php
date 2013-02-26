<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class FonctionRepository extends EntityRepository
{

	    public function findOrCreateByLibelle($libelle){
	        $fonction = $this->findOneBy(array('libele' => $libelle));
	        if ($fonction == null) {
	          $fonction = new \Acme\FmpsBundle\Entity\TypeFonction();
	          $fonction->setLibele($libelle);
	          $this->_em->persist($fonction);
	          $this->_em->flush();
	        }
	        return $fonction;
	    }
}