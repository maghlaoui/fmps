<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true))
            ->add('adresse', 'textarea', array('required' => false))
            ->add('telephone', 'text', array('label' => 'Téléphone', 'required' => false))
            ->add('fax', 'text', array('required' => false))
            ->add('registreCommerce', 'text', array('label' => 'Registre de commerce', 'required' => false))
            ->add('numeroPatente', 'text', array('label' => 'Numéro de patente', 'required' => false))
            ->add('identifiantFiscale', 'text', array('label' => 'Identifiant fiscale', 'required' => false))
            ->add('numeroRib', 'text', array('label' => 'Numéro de RIB', 'required' => false))
            ->add('banque', 'text', array('required' => false))
            ->add('attestationRib', 'file', array('label' => 'Attestation de RIB', 'required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Fournisseur'
	    );
	  }

    public function getName()
    {
        return 'fournisseur';
    }
}
