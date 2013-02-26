<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PasswordResetType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('password', 'repeated', array('label' => 'Mot de passe', 'first_name' => 'Mot de passe',
				           'second_name' => 'Confirmer le mot de passe',
				           'type' => 'password'))
        ;
    }

    public function getName()
    {
        return 'password_reset';
    }
}
