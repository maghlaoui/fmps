<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleMatiere', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('dimMatiere', 'text', array('label' => 'Dim matière', 'required' => false))
        ;
    }

    public function getName()
    {
        return 'matiere';
    }
}
