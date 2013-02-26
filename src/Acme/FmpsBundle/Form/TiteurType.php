<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
class TiteurType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $user = $options['user'];
	      $ecoles = $user->getEcoles();
	
	      if ( !empty($ecoles) && !in_array(1, $ecoles) )
	      {
	         $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
	      }
	      else{
		       $where = 'e.id IN (1)';
	      }
	
        $builder
       
            ->add('cin')
            ->add('nom')
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('nationalite', 'text', array('label' => 'Nationalité', 'required' => false))
            ->add('profession')
            ->add('email')
            ->add('telephone', 'text', array('label' => 'Téléphone personnel', 'required' => false))
            ->add('telephoneBureau', 'text', array('label' => 'Téléphone du bureau', 'required' => false))
            ->add('fix')
            ->add('adresse')
            ->add('ville', 'entity', array('class' => 'AcmeFmpsBundle:Ville', 
                
                  'query_builder' => function (EntityRepository $er) use($where)
                     {
                         return $er->createQueryBuilder('v')
                                ->where('v.id IN (SELECT e.villeId FROM AcmeFmpsBundle:Ecole e WHERE   ' . $where . ')');
                     }
                
                ))
            ->add('typeParente', 'choice', array('choices' => array(1 => 'Père', 2 => 'Mère', 3 => 'Titeur'), 'label' => 'Type de parenté'))
            ->add('numPpr', 'text', array('label' => 'Numéro PPR', 'required' => false))
            ->add('numAdh', 'text', array('label' => "Numéro d'adhésion", 'required' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Titeur',
            'user' => null
        );
    }

    public function getName()
    {
        return 'titeur';
    }
}
