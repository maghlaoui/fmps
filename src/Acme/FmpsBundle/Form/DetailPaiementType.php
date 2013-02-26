<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DetailPaiementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('moisId')
            ->add('serviceId')
            ->add('inscriptionId')
            ->add('paiementId')
            ->add('etat')
            ->add('montant')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\DetailPaiement'
	    );
	  }

    public function getName()
    {
        return 'detail_paiement';
    }
}
