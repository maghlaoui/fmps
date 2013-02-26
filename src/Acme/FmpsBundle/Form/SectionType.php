<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleSection', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('dimSection', 'text', array('label' => 'Dim section', 'required' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Section',
        );
    }

    public function getName()
    {
        return 'section';
    }
}
