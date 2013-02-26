<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
use Acme\FmpsBundle\Util\FmpsLists;

class ArticleBonCommandeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
    		$data = $options['data'];
        if($data && $data->getBonCommandeId() && $data->getId() == ''){
            $bon_commande_id = $data->getBonCommandeId();
            $builder->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 
                'query_builder' => function (EntityRepository $er) use ($bon_commande_id)
                     {
                         return $er->createQueryBuilder('b')
                                ->where('b.id = ?1')
                                ->setParameter(1, $bon_commande_id);
                     }
                     )); 
        }
        else{
            $builder->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande'));
        }
        
        $builder
            //->add('article')
            ->add('article', 'shtumi_ajax_autocomplete', array('entity_alias'=>'articles'))
            ->add('tva', 'choice',  array('choices' => FmpsLists::tva()))
            ->add('prixUnitaire', 'text', array('label' => 'Prix unitaire HT'))
            ->add('quantite', 'text', array('label' => 'Quantité'))
            ->add('unite', 'text', array('label' => 'Unité', 'required' => false))
        ;
    }

    public function getName()
    {
        return 'articleboncommande';
    }
    
     public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\ArticleBonCommande',
        );
    }
}
