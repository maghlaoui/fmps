<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder 
         ->add('rubrique', 'entity', array('class' => 'AcmeFmpsBundle:ActualiteRubrique', 'empty_value' => '--Sélectionnez--', 'label' => 'Rubrique'))
         ->add('title', 'text',array('label' => 'Titre'))
         ->add('content', 'textarea', array('label' => 'Contenu','required'=>true))
         ->add('roles' ,'choice' , array('label' => 'Rôles', 'property_path' => false, 'choices' => FmpsLists::getRolesList(), 'required' => false, 'multiple' => true))
         ->add('published', 'checkbox', array('label'=> 'publié','required'  => false))
            ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Actualite'
	    );
	  }
	
   public function getName()
	 {
      return 'actualite';
   }
}
