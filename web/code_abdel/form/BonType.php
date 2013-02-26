<?php

namespace Acme\fmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class BonType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {

      $user = $options['user'];
      $ecoles = $user->getEcoles();
      if ( !empty($ecoles) && !in_array(1, $ecoles) )
      {
         $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
      }
      else{
	       $where = 'e.id > 1';
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
                ->add('rubrique', 'entity', array('class' => 'AcmeFmpsBundle:Rubrique', 'empty_value' => '--Sélectionnez--', 'label' => 'Rubrique',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                                ->where('r.id IN (SELECT b.rubriqueId FROM AcmeFmpsBundle:Budget b)');
                    }
                ))
                ->add('patente', 'text', array('label' => 'Pattente', 'required' => true))
                ->add('date', 'date', array('required' => true, 'label' => 'Date', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
                ->add('objet', 'textarea')
                ->add('montant')
                ->add('datePaiement', 'date', array('required' => false, 'label' => 'Date paiement', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
                ->add('fichier', 'file', array('label' => 'Upload Bon', 'attr' => array('class' => 'fichier'), 'required' => false))
        ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Bon',
						'user' => null
        );
    }

    public function getName() {
        return 'bon';
    }

}

?>
