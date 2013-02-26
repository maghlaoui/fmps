<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AttachementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            
            ->add('actualite', 'entity', array('class' => 'AcmeFmpsBundle:Actualite', 'empty_value' => '--Sélectionnez--', 'label' => 'Actualite'))
            ->add('fichier', 'file', array('label' => 'Fichier','attr' => array('class' => 'fichier'), 'required' => true))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Attachement'
	    );
	  }

    public function getName()
    {
        return 'attachement';
    }
}
