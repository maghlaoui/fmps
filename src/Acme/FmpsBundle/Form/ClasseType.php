<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class ClasseType extends AbstractType
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
						->add('section', 'entity', array('class' => 'AcmeFmpsBundle:Section', 'empty_value' => '--Sélectionnez--', 'required' => false))
						->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 
						'query_builder' => function (EntityRepository $er)
                 {
                     return $er->createQueryBuilder('a')
													  ->where('a.active = 1')
                            ->orderBy('a.libelleAnneeScolaire', 'DESC');
                 }
                 ))
            ->add('nomClasse', 'text', array('label' => 'Nom', 'required' => true))
            ->add('nombrePlace', 'text', array('label' => 'Nombre de places', 'required' => true))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Classe',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'classe';
    }
}
