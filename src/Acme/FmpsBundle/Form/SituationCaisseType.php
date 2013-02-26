<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class SituationCaisseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
	    $user = $options['user'];
		
           
      $ecoles = $user->getEcoles();
      $months = array('1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai','6'=>'juin','7' => 'Juillet', '8' => 'Aout','9' => 'Septembre','10'=> 'Octobre', '11' => 'Novembre', '12' => 'Décembre');
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
					->add('mois','text',array('read_only' => true))
					->add('annee', 'text', array('label' => 'Année','read_only' => true))
          ->add('soldeInitiale','text',array('read_only'=>true))
          ->add('totalAlimentation','text',array('read_only'=>true))
          ->add('totalAchat','text',array('read_only'=>true))
          ->add('soldeFinale','text',array('read_only'=>true))
					->add('cloture')
					->add('fichier', 'file', array('label' => 'Fichier','required'=>true))
        ;
    }

		public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\SituationCaisse',
	      'user' => null
	    );
	  }

    public function getName()
    {
        return 'situation_caisse';
    }
}
