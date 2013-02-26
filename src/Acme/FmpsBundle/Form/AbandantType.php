<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AbandantType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('inscriptionId')
            ->add('motifSortie', 'text', array('label' => 'Motif d\'abandan'))
            ->add('commentaire', 'textarea')
        ;
    }

		public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Abandant'
	    );
	  }

    public function getName()
    {
        return 'abandant';
    }
}
