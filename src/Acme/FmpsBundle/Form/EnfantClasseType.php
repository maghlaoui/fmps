<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EnfantClasseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
		    $user = $options['user'];
		    $ecoles = $user->getEcoles();
		    if ( !empty($ecoles) && !in_array(1, $ecoles) )
	      {
	         $where = 'c.ecoleId IN (' . implode(', ', $ecoles) . ')';
					 $where1 = 'e.ecoleId IN (' . implode(', ', $ecoles) . ')';
	      }
	      else{
		       $where = 'c.ecoleId > 1';
		       $where1 = 'e.ecoleId > 1';
	      }
		    
        $builder
            ->add('enfant', 'entity', array('class' => 'AcmeFmpsBundle:Enfant', 'label' => 'Enfant', 
	              'query_builder' => function (EntityRepository $er) use ($where1)
	                   {
	                       return $er->createQueryBuilder('e')
																   ->where($where1)
	                                 ->orderBy('e.nom', 'DESC');
	                   }
	                   ))
            ->add('classe', 'entity', array('class' => 'AcmeFmpsBundle:Classe', 'label' => 'Classe', 
	              'query_builder' => function (EntityRepository $er) use ($where)
	                   {
	                       return $er->createQueryBuilder('c')
																->where($where)
	                              ->orderBy('c.nomClasse', 'DESC');
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
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EnfantClasse',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'enfant_classe';
    }
}
