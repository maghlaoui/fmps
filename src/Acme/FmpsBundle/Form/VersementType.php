<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class VersementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('refVirement', 'text', array('label' => 'Référence'))
            ->add('dateOperation', 'date', array('label' => 'Date d\'opération', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateValeur', 'date', array('label' => 'Date de valeur', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('montantVirement', 'text', array('label' => 'Montant de virement'))
            ->add('personnePaiement', 'text', array('label' => 'Effectué par'))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Versement',
        );
    }

    public function getName()
    {
        return 'versement';
    }
}
