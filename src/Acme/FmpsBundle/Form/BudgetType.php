<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('rubrique')
            ->add('annee', 'choice', array('choices' => FmpsLists::getDefaultYears()))
            ->add('montant')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Budget'
	    );
	  }

    public function getName()
    {
        return 'budget';
    }
}
