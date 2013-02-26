<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EcoleCaisseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) 
                     {
                         return $er->createQueryBuilder('e')
                                ->where('e.id > 1');
                     }
                     ))
					 ->add('numeroCompte', 'text', array('label' => 'Numéro du compte'))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EcoleCaisse'
	    );
	  }

    public function getName()
    {
        return 'ecole_caisse';
    }
}
