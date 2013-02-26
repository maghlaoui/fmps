<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ActualiteRubriqueType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
           
            ->add('description', 'textarea', array('required' => false))
            ->add('published', 'checkbox', array('label'=> 'publié','required'  => false))
            
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\ActualiteRubrique'
	    );
	  }

    public function getName()
    {
        return 'actualite_rubrique';
    }
}
