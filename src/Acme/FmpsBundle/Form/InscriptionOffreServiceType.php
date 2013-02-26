<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class InscriptionOffreServiceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
			 $data = $options['data'];
		   $inscription_id = $data->getInscriptionId();
		   $builder
					  ->add('inscription', 'entity', array('class' => 'AcmeFmpsBundle:Inscription', 'label' => 'Enfant', 
			                'query_builder' => function (EntityRepository $er) use ($inscription_id) 
			                     {
			                         return $er->createQueryBuilder('i')
			                                ->where('i.id = ?1')
			                                ->setParameter(1, $inscription_id);
			                     }
			                     ))
            ->add('offreService', 'entity', array('class' => 'AcmeFmpsBundle:OffreService', 'label' => 'Offre de service', 'empty_value' => '--Sélectionnez--'))
            ->add('mois' ,'choice' , array('choices' => FmpsLists::getMonths(), 'empty_value' => '--Sélectionnez--'))
            ->add('status' ,'choice' , array('choices' => FmpsLists::getDefaultOffreStatus(), 'empty_value' => '--Sélectionnez--'))
						->add('commentaire')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\InscriptionOffreService'
	    );
	  }

    public function getName()
    {
       return 'inscription_offre_service';
    }
}
