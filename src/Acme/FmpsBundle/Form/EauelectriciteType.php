<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EauelectriciteType extends AbstractType
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
						->add('budget', 'entity', array('empty_value' => '--Sélectionnez--', 'class' => 'AcmeFmpsBundle:Budget', 'label' => 'Budget', 
						              'query_builder' => function (EntityRepository $er) use ($where1)
						                   {
						                       return $er->createQueryBuilder('b')
						                              ->where($where1);
						                   }
						                   ))
						->add('fournisseur')
						->add('service', 'choice', array('label' => 'Service', 'choices' => array('Eaux' => 'Eaux', 'Electricité' => 'Electricité', 'Eaux et electricité' => 'Eaux et electricité')))
            ->add('numfacture', 'text', array('label' => 'Numéro de facture'))
						->add('datefacture', 'date', array('label' => 'Date de facture', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('modefacturation', 'choice', array('label' => 'Mode de facturation', 'choices' => array('Mensuele' => 'Mensuele', 'Trimistriel' => 'Trimistriel')))
						->add('periodedebut', 'date', array('label' => 'Début de période', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
						->add('periodefin', 'date', array('label' => 'Fin de période', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('montant', 'money', array('label' => 'Montant', 'currency' => 'Dhs'))
            ->add('penalite', 'money', array('label' => 'Pénalité', 'currency' => 'Dhs', 'required' => false ))
						->add('datepaiement', 'date', array('label' => 'Date de paiement', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
						->add('typepaiement', 'choice', array('label' => 'Type de paiement', 'choices' => array('Espèce' => 'Espèce', 'Chèque' => 'Chèque', 'Virement' => 'Virement'), 'empty_value' => 'Sélectionnez', 'required' => false))
            ->add('numcheque', 'text', array('label' => 'Numéro (Chèque/Virement)', 'required' => false))
						->add('fichier', 'file', array('label' => 'Upload facture', 'required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Eauelectricite',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'eau_electricite';
    }
}
