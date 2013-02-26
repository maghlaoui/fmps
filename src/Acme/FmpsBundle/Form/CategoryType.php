<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array('label' => 'Libellé', 'required' => true))
						->add('commentaire', 'textarea', array('label' => 'Commentaire', 'required' => false));
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Category'
	    );
	  }

    public function getName()
    {
        return 'category';
    }
}
