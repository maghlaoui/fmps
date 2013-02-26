<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nomContact', 'text', array('label' => 'Nom', 'required' => true))
            ->add('prenomContact', 'text', array('label' => 'Prénom', 'required' => true))
            ->add('tel1Contact', 'text', array('label' => 'Téléphone 1', 'required' => true))
            ->add('tel2Contact', 'text', array('label' => 'Téléphone 2', 'required' => false))
            ->add('faxContact', 'text', array('label' => 'Fax', 'required' => false))
            ->add('mailContact', 'text', array('label' => 'E-mail', 'required' => false))
            ->add('statusContact', 'text', array('label' => 'Status', 'required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Contact'
	    );
	  }

    public function getName()
    {
        return 'contact';
    }
}
