<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class OffreServiceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) 
                     {
                         return $er->createQueryBuilder('e')->where('e.id > 1');
                     }
                     ))
            ->add('service')
						->add('category', 'entity', array('class' => 'AcmeFmpsBundle:Category', 'label' => 'Catégorie'))
            ->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 
	              'query_builder' => function (EntityRepository $er) 
	                   {
	                       return $er->createQueryBuilder('a')
	                              ->orderBy('a.libelleAnneeScolaire', 'DESC');
	                   }
	                   ))
            ->add('montantService', 'text', array('label' => 'Montant', 'required' => true));
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\OffreService'
	    );
	  }

    public function getName()
    {
        return 'offre_service';
    }
}
