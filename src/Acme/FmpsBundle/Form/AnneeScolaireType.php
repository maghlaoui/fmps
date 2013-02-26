<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AnneeScolaireType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelleAnneeScolaire', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('dateDebutAnneeScolaire', 'date', array('label' => 'Date de début', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateFinAnneeScolaire', 'date', array('label' => 'Date de fin', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
						->add('active')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\AnneeScolaire'
	    );
	  }

    public function getName()
    {
        return 'annee_scolaire';
    }
}
