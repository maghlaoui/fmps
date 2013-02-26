<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class AlimentationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 'empty_value' => '--Sélectionnez--',
		 'required' => false, 
              'query_builder' => function (EntityRepository $er) 
                   {
                       return $er->createQueryBuilder('e')
                              ->where('e.id > 1');
                   }
                   ))
            ->add('numero', 'text', array('label' => 'Numéro'))
						->add('objet', 'text')
            ->add('montant')
            ->add('date', 'date', array('required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Alimentation'
	    );
	  }

    public function getName()
    {
        return 'alimentation';
    }
}
