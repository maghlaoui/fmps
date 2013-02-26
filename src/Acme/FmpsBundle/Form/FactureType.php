<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Entity\Facture;
use Doctrine\ORM\EntityRepository;

class FactureType extends AbstractType
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
             $builder->add('bonCommande', 'entity', array('required' => false, 'class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 'empty_value' => 'Sélectionnez un bon de commande'));
            
        }
        $builder
            ->add('numero', 'text', array('label' => 'Numéro de facture'))
            ->add('dateCreation', 'date', array('label' => 'Date de facture', 'required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date')))
            ->add('montant', 'text', array('label' => 'Total TTC'))
            ->add('etat', 'choice',  array('choices' => Facture::getDefaultStatus()))
            ->add('datePrevisionPaiement', 'date', array('label' => 'Date de prévision de paiement', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')))
            ->add('datePaiement', 'date', array('label' => 'Date de paiement', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('typePaiement', 'choice',  array('choices' => Facture::getDefaultPaymentTypes(), 'label' => 'Type de paiement'))
            ->add('fichier', 'file', array('label' => 'Fichier', 'required' => false))
            
            ;
            
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Facture'
	    );
	  }

    public function getName()
    {
        return 'facture';
    }
}
