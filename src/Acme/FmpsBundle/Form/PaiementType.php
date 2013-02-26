<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
						->add('inscription', 'entity', array('class' => 'AcmeFmpsBundle:Inscription', 'read_only' => true, 'label' => 'Enfant', 
	                'query_builder' => function (EntityRepository $er)
	                     {
	                         return $er->createQueryBuilder('i')
	                                ->andwhere('i.validated IS NULL');
	                     }
	                     ))
	          ->add('inscriptionId', 'hidden')
            ->add('matricule', 'text', array('read_only' => true))
            ->add('datePaiement', 'date', array('label' => 'Date de paiement', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('moyenPaiement', 'choice', array('label' => 'Moyen de paiement', 'choices' => array('Virement' => 'Virement', 'Espèce' => 'Espèce')))
            ->add('nomPersonnePaiement', 'text', array('label' => 'Payé par'))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Paiement'
	    );
	  }

    public function getName()
    {
        return 'paiement';
    }
}
