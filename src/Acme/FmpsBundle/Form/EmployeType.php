<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('matricule')
            ->add('nom')
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('tel', 'text', array('label' => 'Téléphone', 'required' => false))
            ->add('flote', 'text', array('label' => 'Flotte', 'required' => false))
            ->add('cin', 'text', array('required' => true))
            ->add('cnss', 'text', array('required' => false))
						->add('rib', 'text', array('required' => false))
					  ->add('adresse', 'textarea', array('required' => false))
					  ->add('dateNaissance', 'date', array('label' => 'Date de naissance', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('superieur', 'entity', array('class' => 'AcmeFmpsBundle:Employe', 'empty_value' => '--Sélectionnez--', 'label' => 'Supérieur', 'required' => false))
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Affectation', 'empty_value' => '--Sélectionnez--'))
            ->add('dateAffectation', 'date', array('property_path' => false, 'required' => false, 'label' => 'Date d\'affectation',  'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('fonction', 'entity', array('class' => 'AcmeFmpsBundle:Fonction', 'empty_value' => '--Sélectionnez--'))
						->add('dateFonction', 'date', array('property_path' => false, 'required' => false, 'label' => 'Date de début de fonction', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('fichier', 'file', array('label' => 'photo', 'required' => false))
            ->add('roles' ,'choice' , array('label' => 'Rôles', 'property_path' => false, 'choices' => FmpsLists::getRolesList(), 'required' => false, 'multiple' => true));            
        
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Employe'
	    );
	  }

    public function getName()
    {
        return 'employe';
    }
}
