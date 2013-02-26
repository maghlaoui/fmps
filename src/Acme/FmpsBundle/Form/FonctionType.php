<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FonctionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libele', 'text', array('label' => 'Libellé', 'required' => true))
            ->add('niveauHierarchique', 'text', array('label' => 'Niveau hiérarchique', 'required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Fonction'
	    );
	  }

    public function getName()
    {
        return 'fonction';
    }
}
