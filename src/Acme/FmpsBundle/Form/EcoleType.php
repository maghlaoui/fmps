<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Entity\User;

class EcoleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
	      $user = $options['user'];
	      $read_only = true;
	      if ($user instanceof User) $read_only = !$user->hasRole('ROLE_SUPER_ADMIN');

        $builder
            ->add('nom', 'text', array('label' => 'Nom', 'required' => true))
            ->add('adresse', 'textarea', array('label' => 'Adresse'))
            ->add('tel1', 'text', array('label' => 'Téléphone 1', 'required' => true))
            ->add('tel2', 'text', array('label' => 'Téléphone 2', 'required' => false))
            ->add('fax', 'text', array('label' => 'Fax', 'required' => false))
            ->add('email', 'text', array('label' => 'Email', 'required' => true))
            ->add('lattitude', 'text', array('label' => 'Latitude', 'required' => false))
            ->add('longitude', 'text', array('label' => 'Longitude', 'required' => false))
            ->add('superficie', 'text', array('label' => 'Superficie', 'required' => true))
            ->add('nomCompteBancaire', 'text', array('label' => 'Nom du compte bancaire', 'required' => true, 'read_only' => $read_only))
            ->add('numeroCompte', 'text', array('label' => 'Numéro du compte bancaire', 'required' => true, 'read_only' => $read_only))
            ->add('numeroRib', 'text', array('label' => 'Numéro du RIB', 'required' => true, 'read_only' => $read_only))
            ->add('dateOuverture', 'date', array('label' => "Date d'ouverture", 'required' => false, 'widget' => 'single_text', 'read_only' => $read_only, 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('fichier', 'file', array('label' => 'Photo', 'required' => false))
            ->add('ville')
            ->add('reseau_prescolaire', 'entity', array('class' => 'AcmeFmpsBundle:ReseauPrescolaire', 'label' => 'Réseau préscolaire', 'read_only' => $read_only))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Ecole',
				'user' => null
	    );
	  }

    public function getName()
    {
        return 'ecole';
    }
}
