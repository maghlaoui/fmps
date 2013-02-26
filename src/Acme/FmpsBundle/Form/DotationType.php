<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class DotationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
             ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
			 'required' => false, 
	              'query_builder' => function (EntityRepository $er) 
	                   {
	                       return $er->createQueryBuilder('e')
	                              ->where('e.id > 1');
	                   }
	                   ))
            ->add('montant')
            ->add('annee', 'text', array('label' => 'Année'))
            ->add('periode', 'text', array('label' => 'Période'))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Dotation'
	    );
	  }

    public function getName()
    {
        return 'dotation';
    }
}
