<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class SuiviArgPartType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
		$data = $options['data'];
        if($data && $data->getPartenariatPartenaireId() && $data->getId() == ''){
            $partenariat_partenaire_id = $data->getPartenariatPartenaireId();

            $builder->add('partenariatPartenaire', 'entity', array('class' => 'AcmeFmpsBundle:PartenariatPartenaire', 'label' => 'Partenaire', 
                'query_builder' => function (EntityRepository $er) use ($partenariat_partenaire_id)
                     {
                         return $er->createQueryBuilder('p')
                                ->where('p.id = ?1')
                                ->setParameter(1, $partenariat_partenaire_id);
                     }
                     )); 
        }
        else{
            $builder->add('partenariatPartenaire', 'entity', array('class' => 'AcmeFmpsBundle:PartenariatPartenaire', 'label' => 'Partenaire'));
        }
        $builder
            ->add('montant')
            ->add('dateReception', 'date', array('label' => 'Date de réception', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')));
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\SuiviArgPart',
        );
    }

    public function getName()
    {
        return 'suivi_arg_part';
    }
}
