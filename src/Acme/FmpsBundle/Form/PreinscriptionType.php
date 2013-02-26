<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class PreinscriptionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $user = $options['user'];
	      $ecoles = $user->getEcoles();
	      if ( !empty($ecoles) && !in_array(1, $ecoles) )
	      {
	         $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
	      }
	      else{
		       $where = 'e.id > 1';
	      }

        $builder
						->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) use ($where)
                     {
                         return $er->createQueryBuilder('e')
                                ->where($where);
                     }
                     ))
            ->add('nomEnfant', 'text', array('label' => 'Nom de l\'enfant'))
            ->add('prenomEnfant', 'text', array('label' => 'Prénom de l\'enfant'))
            ->add('nomTiteur', 'text', array('label' => 'Nom du tuteur'))
            ->add('prenomTiteur', 'text', array('label' => 'Prénom du tuteur'))
						->add('telephoneTiteur', 'text', array('label' => 'Téléphone'))
            ->add('section')
            ->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 
	              'query_builder' => function (EntityRepository $er) 
	                   {
	                       return $er->createQueryBuilder('a')
															  ->where('a.active = 1')
	                              ->orderBy('a.libelleAnneeScolaire', 'DESC');
	                   }
	                   ))
						->add('category', 'entity', array('class' => 'AcmeFmpsBundle:Category', 'label' => 'Catégorie'))
            ->add('commentaire', 'textarea', array('required' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Preinscription',
 						'user' => null
        );
    }

    public function getName()
    {
        return 'preinscription_type';
    }
}
