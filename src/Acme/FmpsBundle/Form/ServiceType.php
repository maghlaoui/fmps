<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleService', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('demService', 'text', array('label' => 'Dem service', 'required' => false))
						->add('obligatoire')
						->add('periode', 'choice', array('label' => 'Période', 'choices' => array('mensuelle' => 'mensuelle', 'annuelle' => 'annuelle')))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Service',
        );
    }

    public function getName()
    {
        return 'service';
    }
}
