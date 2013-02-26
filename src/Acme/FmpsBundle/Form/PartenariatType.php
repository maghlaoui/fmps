<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PartenariatType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libellePartenariat', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('datePatenariat', 'date', array('label' => 'Date de début', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateFinPartenariat', 'date', array('label' => 'Date de fin', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('objetPartenariat', 'textarea', array('label' => 'Objet de participation', 'required' => false))
            ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Partenariat',
        );
    }

    public function getName()
    {
        return 'partenariat';
    }
}
