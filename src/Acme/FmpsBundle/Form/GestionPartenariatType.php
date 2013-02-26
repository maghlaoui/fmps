<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;


class GestionPartenariatType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {   
        $data = $options['data'];
        if($data && $data->getPartenariatId() && $data->getId() == ''){
            $partenariat_id = $data->getPartenariatId();
            $builder->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 
                'query_builder' => function (EntityRepository $er) use ($partenariat_id)
                     {
                         return $er->createQueryBuilder('p')
                                ->where('p.id = ?1')
                                ->setParameter(1, $partenariat_id);
                     }
                     )); 
        }
        else{
            $builder->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat')); 
        }
        
        $builder
            ->add('contact', 'entity', array('class' => 'AcmeFmpsBundle:Contact'))
            ->add('dateAffectationGestion', 'date', array('label' => 'Date de début', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateFinAffectationGestion', 'date', array('label' => 'Date de fin', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\GestionPartenariat'
	    );
	  }

    public function getName()
    {
        return 'gestion_partenariat';
    }
}
