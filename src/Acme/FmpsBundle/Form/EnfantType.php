<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EnfantType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
 	  
        $builder
            ->add('nom')
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('sexe', 'choice', array('choices' => array('masculin' => 'Masculin', 'féminin' => 'féminin')))
            ->add('dateNaissance', 'date', array('label' => 'Date de naissance', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('lieuNaissance', 'text', array('label' => 'Lieu de naissance', 'required' => false))
            ->add('nationalite', 'text', array('required' => false, 'label' => 'Nationalité'))
            ->add('ecoleFreq', 'text', array('label' => 'Ecole freqenté', 'required' => false))
            ->add('fichier', 'file', array('label' => 'Photo', 'required' => false))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Enfant',
        'user' => null
	    );
	  }

    public function getName()
    {
        return 'enfant';
    }
}
