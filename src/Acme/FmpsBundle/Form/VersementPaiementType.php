<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class VersementPaiementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('virementId')
            ->add('paiementId')
            ->add('montantVerse')
            ->add('montantPaiement')
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\VersementPaiement',
        );
    }

    public function getName()
    {
        return 'versement_paiement';
    }
}
