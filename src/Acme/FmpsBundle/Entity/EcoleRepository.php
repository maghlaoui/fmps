<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class EcoleRepository extends EntityRepository
{
    
   public function findBySearchCriteria($options, $user = null)
    {

      $qb = $this->createQueryBuilder('e')
                 ->select('e, v, r')
                 ->leftJoin('e.ville', 'v')
       					 ->leftJoin('e.reseau_prescolaire', 'r');

			$ecoles = $user->getEcoles();
     
			if ($user && !empty($ecoles) && !in_array(1, $ecoles))
      {
          $qb->andWhere($qb->expr()->in('e.id', $ecoles));
      }

      if ($options->getNom() && $options->getNom() != '')
      {
          $qb->andWhere('e.nom = :nom')->setParameter('nom', $options->getNom());
      }
      
      if ($options->getAdresse() && $options->getAdresse() != '')
      {
          $qb->andWhere('e.adresse = :adresse')->setParameter('adresse', $options->getAdresse());
      }
      
      if ($options->getVille() && $options->getVille() != '')
      {
          $qb->andWhere('e.villeId = :ville')->setParameter('ville', $options->getVille());
      }
      
      if ($options->getReseauPrescolaire() && $options->getReseauPrescolaire() != '')
      {
          $qb->andWhere('e.reseauPrescolaireId = :ville')->setParameter('ville', $options->getReseauPrescolaire());
      }
      
      if ($options->getDateOuverture() && $options->getDateOuverture() != '')
      {
          $qb->andWhere('e.dateOuverture = :adresse')->setParameter('adresse', $options->getDateOuverture());
      }
      
      return $qb->getQuery();
    }
    
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

		public function getEcolesForSelect($id = null){
			$qb = $this->createQueryBuilder('e')->select('e.id, e.nom')->andWhere('e.id > 1');
			if ($id =! null) $qb->andWhere('e.id = :id')->setParameter('id', $id);
			return $qb->getQuery()->getResult();
		}
		
		public function etablissementsForSelect(){
			return $this->createQueryBuilder('e')->select('e.id, e.nom')->getQuery();
		}
		
		public function getCount(){
			return $this->createQueryBuilder('e')
			 ->select('COUNT(e)')
			 ->getQuery()
			 ->getSingleScalarResult();
		}
		
		public function getInscriptions($ecoleId){
			$qb = $this->createQueryBuilder('i')
								 ->select('i')
								 ->add('from', 'Acme\FmpsBundle\Entity\Inscription i')
								 //->leftJoin('ec.classe', 'c')
								 //->leftJoin('ec.employe', 'e')
								 //->leftJoin('ec.anneeScolaire', 'a')
								 ->andWhere('i.ecoleId =' .$ecoleId)
								 ->groupBy('i.sectionEcoleId');

			return $qb->getQuery()->getResult();
		}
		    
}