<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array ('label' => 'Identifiant'))
            ->add('email')
            ->add('enabled', 'checkbox', array('label' => 'active'))
            ->add('employe', 'entity', array(
                'class' => 'AcmeFmpsBundle:Employe', 'label' => 'Employé', 'empty_value' => 'Sélectionnez un employé',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                              ->orderBy('e.prenom', 'ASC');
                },
            ))
            ->add('roles' ,'choice' , array('choices' => FmpsLists::getRolesList(), 'required' => false, 'multiple' => true, 'label' => 'roles'))
            //->add('password', 'password', array('label' => 'Mot de passe', 'required' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\User',
        );
    }

    public function getName()
    {
        return 'user';
    }
}
