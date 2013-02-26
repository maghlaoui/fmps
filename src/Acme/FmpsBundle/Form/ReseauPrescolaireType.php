<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReseauPrescolaireType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleReseauPrescolaire', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('partenariat')
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\ReseauPrescolaire',
        );
    }

    public function getName()
    {
        return 'reseau_prescolaire';
    }
}
