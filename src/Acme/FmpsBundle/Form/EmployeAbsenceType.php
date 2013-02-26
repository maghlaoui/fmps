<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class EmployeAbsenceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
	      $ids = $options['employes'];
        $builder
						->add('employe', 'entity', array(
                'class' => 'AcmeFmpsBundle:Employe', 'label' => 'Employé', 'empty_value' => 'Sélectionnez un employé',
                'query_builder' => function(EntityRepository $er) use ($ids) {
                    return $er->createQueryBuilder('e') 
											  ->where('e.id IN (' . implode(', ', $ids) . ')')
                        ->orderBy('e.prenom, e.nom', 'ASC');
                },
            ))
						->add('du', 'date', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
						->add('au', 'date', array('required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
						->add('motif', 'choice', array('choices' => FmpsLists::getDefaultMotifs(), 'empty_value' => '--Sélectionnez--'))
            ->add('justifie', 'checkbox', array('label' => 'Justifiée', 'required' => false))
            ->add('commentaire', 'textarea', array('required' => false))
						->add('fichier', 'file', array('required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EmployeAbsence',
				'employes' => array()
	    );
	  }

    public function getName()
    {
        return 'employe_absence';
    }
}
