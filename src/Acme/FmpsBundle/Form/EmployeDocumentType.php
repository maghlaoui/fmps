<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EmployeDocumentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('employe')
            ->add('titre')
            ->add('fichier', 'file', array('label' => 'Fichier', 'required' => false))
						->add('type_document', 'entity', array('class' => 'AcmeFmpsBundle:TypeDocument', 'label' => 'Type du document'));
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EmployeDocument'
	    );
	  }

    public function getName()
    {
        return 'employe_document';
    }
}
