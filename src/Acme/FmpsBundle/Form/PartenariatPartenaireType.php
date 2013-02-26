<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Entity\PartenariatPartenaire;
use Doctrine\ORM\EntityRepository;

class PartenariatPartenaireType extends AbstractType
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
            ->add('partenaire', 'entity', array('class' => 'AcmeFmpsBundle:Partenaire'))
						->add('type_engagement', 'entity', array('class' => 'AcmeFmpsBundle:TypeEngagement', 'label' => 'Type d\'engagement'))
						->add('type_contribution', 'entity', array('class' => 'AcmeFmpsBundle:TypeContribution', 'label' => 'Périodicité'))
						->add('montantParticipation', 'text', array('label' => 'Montant de participation', 'required' => false))
            ->add('detail', 'textarea', array('label' => 'Détail', 'required' => false))
         ;
        
        
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\PartenariatPartenaire',
        );
    }

    public function getName()
    {
        return 'partenariat_partenaire';
    }
}
