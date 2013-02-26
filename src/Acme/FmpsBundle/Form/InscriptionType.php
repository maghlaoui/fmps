<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {

        $user = $options['user'];
	      $ecoles = $user->getEcoles();
	      $schools = implode(', ', $ecoles);
	      if ( !empty($ecoles) && !in_array(1, $ecoles) )
	      {
	         $where = 'e.id IN (' . implode(', ', $ecoles) . ')';
	         $where1 = 'o.ecoleId IN (' . implode(', ', $ecoles) . ')';
	      }
	      else{
		       $where = 'e.id > 1';
		       $where1 = 'o.ecoleId IN (1)';
	      }

        $builder
						->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) use ($where)
                     {
                         return $er->createQueryBuilder('e')
                                ->where($where);
                     }
                     ))
            ->add('numDemande', 'text', array('label' => 'Numéro de la demande'))
            ->add('dateDemande', 'date', array('label' => 'Date de la demande', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateEntree', 'date', array('label' => 'Date d\'entré', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            //->add('dateSortie', 'date', array('label' => 'Date de sortie', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date')))
            ->add('category', 'entity', array('class' => 'AcmeFmpsBundle:Category', 
                
                  'query_builder' => function (EntityRepository $er) use($where1)
                     {
                         return $er->createQueryBuilder('c')
                                ->where('c.id IN (SELECT o.categoryId FROM AcmeFmpsBundle:OffreService o WHERE   ' . $where1 . ')');
                     }
                
                ))
            ->add('anneeScolaire', 'entity', array('class' => 'AcmeFmpsBundle:AnneeScolaire', 'label' => 'Année scolaire', 
							'query_builder' => function (EntityRepository $er)
	                 {
	                     return $er->createQueryBuilder('a')
														  ->where('a.active = 1')
	                            ->orderBy('a.libelleAnneeScolaire', 'DESC');
	                 }
	                 ))
            ->add('section', 'entity', array('class' => 'AcmeFmpsBundle:Section', 'empty_value' => '--Sélectionnez--'))
            ->add('enfant', 'entity', array('class' => 'AcmeFmpsBundle:Enfant', 
                
                  'query_builder' => function (EntityRepository $er) use($schools)
                     {
                         return $er->createQueryBuilder('e')
                                ->where('e.ecoleId IN (' . $schools . ')');
                     }
                
                ))
            ->add('titeur', 'entity', array('class' => 'AcmeFmpsBundle:Titeur', 'label' => 'Tuteur',

			                  'query_builder' => function (EntityRepository $er) use($schools)
			                     {
			                         return $er->createQueryBuilder('t')
			                                ->where('t.ecoleId IN (' . $schools . ')');
			                     }

			                ))
			      //->add('typeDemande', 'choice', array('label' => 'Type de demande', 'choices' => array(1 => 'Inscription', 2 => 'Réinscription', 3 => 'Transfère')))
						//->add('etatDemande', 'choice', array('label' => 'Etat de demande', 'choices' => array(1 => 'Liste principale', 2 => 'Liste d\'attente', 3 => 'Annulé', 4 => 'Rejeté', 5 => 'Abandant')))
            //->add('assurance')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Inscription',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'inscription';
    }
}
