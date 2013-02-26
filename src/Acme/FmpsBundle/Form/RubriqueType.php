<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RubriqueType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('intitule', 'text', array('label' => 'Intitulé'))
            ->add('chapitre')
            ->add('article')
            ->add('paragraphe')
            ->add('ammortissable')
            ->add('dureeAmmortissement', 'number', array('label' => "Durée d'amortissement", 'required'  => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Rubrique',
        );
    }

    public function getName()
    {
        return 'rubrique';
    }
}
