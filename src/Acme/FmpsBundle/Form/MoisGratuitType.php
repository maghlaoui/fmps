<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MoisGratuitType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('offreServiceId')
            ->add('mois')
            ->add('commentaire')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\MoisGratuit'
	    );
	  }

    public function getName()
    {
        return 'mois_gratuit';
    }
}
