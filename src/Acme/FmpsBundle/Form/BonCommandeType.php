<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Entity\BonCommande;
use Doctrine\ORM\EntityRepository;

class BonCommandeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $data = $options['data'];
        if($data && $data->getId() != ''){
            $builder->add('status', 'choice', array('choices' => BonCommande::getDefaultStatus(), 'required'  => false, ));
        }
        
        $builder
            ->add('numero', 'text', array('label' => 'Numéro'))
            ->add('objet')
            ->add('rubrique', 'entity', array(
                'class' => 'AcmeFmpsBundle:Rubrique', 'label' => 'Intitulé de la rubrique', 'empty_value' => 'Sélectionnez une rubrique',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.intitule', 'ASC');
                },
            ))
            ->add('fournisseur', 'entity', array(
                'class' => 'AcmeFmpsBundle:Fournisseur', 'label' => 'Fournisseur', 'empty_value' => 'Sélectionnez un fournisseur',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                              ->orderBy('f.nom', 'ASC');
                },
            ))
            ->add('dateBc', 'date', array('label' => 'Date du bon de commande', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('fichierDa', 'file', array('label' => 'Demande d\'achat', 'required' => false))
            ->add('fichierBc', 'file', array('label' => 'Bon de commande', 'required' => false))
			      ->add('affectation', 'text', array('required' => false))
			      ->add('remise', 'percent', array('required' => false, 'label' => 'Remise (%)', 'data' => 0))
            ->add('ttc', 'checkbox', array('label' => 'TTC', 'required' => false, 'attr' => array('class' => 'checkbox inline')))
            ;
    }

    public function getName()
    {
        return 'boncommande';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\BonCommande',
        );
    }
}
