<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class EcoleAchatType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
	    $user = $options['user'];
      $ecoles = $user->getEcoles();
      if ( !empty($ecoles) && !in_array(1, $ecoles) )
      {
         $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
				 $where1 = 'b.id IN (SELECT eb.budgetId FROM Acme\FmpsBundle\Entity\EcoleBudget eb WHERE eb.ecoleId IN (' . implode(', ', $ecoles) . '))';
      }
      else{
	       $where = 'e.id > 1';
				 $where1 = 'b.id IN (SELECT eb.budgetId FROM Acme\FmpsBundle\Entity\EcoleBudget eb WHERE eb.ecoleId > 1)';
      }
		
        $builder
					->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
              'query_builder' => function (EntityRepository $er) use ($where)
                   {
                       return $er->createQueryBuilder('e')
                              ->where($where);
                   }
                   ))
					->add('fournisseur')
					->add('numFacture', 'text', array('label' => 'Numéro de facture'))
					->add('date', 'date', array('format' => 'dd-MM-yyyy', 'required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
					->add('objet', 'textarea')
					//TODO get only availabale rubrique
					->add('budget', 'entity', array('empty_value' => '--Sélectionnez--', 'class' => 'AcmeFmpsBundle:Budget', 'label' => 'Budget', 
              'query_builder' => function (EntityRepository $er) use ($where1)
                   {
                       return $er->createQueryBuilder('b')
                              ->where($where1);
                   }
                   ))
					->add('montant', 'money', array('currency' => 'Dhs'))
					->add('etatFacture', 'choice', array('label' => 'Etat de facture', 'choices' => FmpsLists::getDefaultOrderStatus(), 'empty_value' => '--Sélectionnez--')) 
					->add('datePaiementFacture', 'date', array('format' => 'dd-MM-yyyy', 'label' => 'Date de paiement', 'required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
          ->add('modePayement', 'choice', array('label' => 'Mode de règlement', 'choices' => FmpsLists::getDefaultPaymentTypes(), 'required' => false, 'empty_value' => '--Sélectionnez--'))
					->add('numeroCheque', 'text', array('label' => 'Numéro (Chèque/Virement)', 'required' => false, 'attr' => array('class' => 't')))
					->add('fichier', 'file', array('label' => 'Fichier', 'required' => false))
					   
        ;
    }

		public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EcoleAchat',
	      'user' => null
	    );
	  }

    public function getName()
    {
        return 'ecole_achat';
    }
}
