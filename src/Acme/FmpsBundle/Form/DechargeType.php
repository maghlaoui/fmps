<?php

namespace Acme\fmpsBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class DechargeType extends abstractType{
    
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
           ->add('nom','text')
           ->add('prenom', 'text', array('label' => 'Prénom','required' => true))
           ->add('cin','text',array('label'=>'CIN','required'=>true))
           ->add('date', 'date', array( 'required' => true, 'label' => 'Date',  'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
           ->add('objet', 'textarea')
           ->add('natureDepense', 'text', array('label' => 'Nature de dépence'))
           ->add('montant', 'money', array('currency' => 'Dhs'))
           ->add('datePaiement', 'date', array('required' => false, 'label' => 'Date paiement',  'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
           ->add('fichier', 'file', array('label' => 'Upload décharge', 'attr' => array('class' => 'fichier'), 'required' => false))
        ;
      
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Decharge',
				'user' => null
	    );
	  }
    
     public function getName()
	{
        return 'decharge';
    }
}
?>
