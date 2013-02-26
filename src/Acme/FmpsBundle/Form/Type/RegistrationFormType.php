<?php

namespace Acme\FmpsBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Acme\FmpsBundle\Entity\User;
use Acme\FmpsBundle\Util\FmpsLists;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('roles' ,'choice' ,array('choices' => FmpsLists::getRolesList(), 'required' => false, 'multiple' => true, 'label' => 'Roles'));
    }

    public function getName()
    {
        return 'acme_user_registration';
    }
}