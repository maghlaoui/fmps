<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class EmployeClasseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
		    $user = $options['user'];
		    $ecoles = $user->getEcoles();
		
        $builder
            ->add('employe', 'entity', array('class' => 'AcmeFmpsBundle:Employe', 'label' => 'Employé', 
	              'query_builder' => function (EntityRepository $er) use ($user)
	                   {
												 $qb = $er->createQueryBuilder('e');
	                       return $qb->andWhere($qb->expr()->in('e.id', $user->getEmployes()))
	                              ->andWhere('e.ecoleId > 1')
																->orderBy('e.prenom', 'ASC');
	                   }
	                   ))
            ->add('classe', 'entity', array('class' => 'AcmeFmpsBundle:Classe', 'label' => 'Classe', 
						              'query_builder' => function (EntityRepository $er) use ($ecoles)
						                   {
																	 $qb = $er->createQueryBuilder('c');
						                       return $qb->andWhere($qb->expr()->in('c.ecoleId', $ecoles));
						                   }
						                   ))
						->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 
	              'query_builder' => function (EntityRepository $er) 
	                   {
	                       return $er->createQueryBuilder('a')
															  ->where('a.active = 1')
	                              ->orderBy('a.libelleAnneeScolaire', 'DESC');
	                   }
	                   ))
						->add('langues', 'choice', array('choices' => FmpsLists::getDefaultLanguages(), 'empty_value' => '--Sélectionnez--'))
        ;
					
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EmployeClasse',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'employe_classe';
    }
}
