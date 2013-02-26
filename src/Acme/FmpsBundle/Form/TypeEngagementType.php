<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TypeEngagementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleTypeEngagement', 'text', array('label' => 'Libellé', 'required' => true));
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\TypeEngagement',
        );
    }

    public function getName()
    {
        return 'type_engagement';
    }
}
