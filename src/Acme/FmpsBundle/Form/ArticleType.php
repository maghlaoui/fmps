<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('designation', 'textarea', array('label' => 'Désignation'))
            ->add('description', 'textarea', array('required' => false))
           ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Article'
	    );
	  }

    public function getName()
    {
        return 'article';
    }
}
