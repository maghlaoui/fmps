<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TypeDocumentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleTypedocument', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('racineTypedocument', 'text', array('label' => 'Racine', 'required' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\TypeDocument',
        );
    }

    public function getName()
    {
        return 'type_document';
    }
}
