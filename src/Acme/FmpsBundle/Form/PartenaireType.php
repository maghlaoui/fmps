<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setErrorBubbling(true)
            ->add('nomPartenaire', 'text', array('label' => 'Nom', 'required' => true))
            ->add('adressePartenaire', 'text', array('label' => 'Adresse', 'required' => false))
            ->add('tel1Partenaire', 'text', array('label' => 'Téléphone 1', 'required' => false))
            ->add('tel2Partenaire', 'text', array('label' => 'Téléphone 2', 'required' => false))
            ->add('faxPartenaire', 'text', array('label' => 'Fax', 'required' => false))
            ->add('mailPartenaire', 'text', array('label' => 'E-mail', 'required' => false))
            ->add('siteWebPartenaire', 'text', array('label' => 'Site web', 'required' => false))
            ->add('ville', 'entity', array('class' => 'AcmeFmpsBundle:Ville', 'empty_value' => 'Sélectionnez une ville'))
           //->add('contacts', 'entity', array('class' => 'AcmeFmpsBundle:Contact', 'multiple' => true, 'label' => 'Contact partenaire', 'required' => false, 'property_path' => false))
        ;
    }

		public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\FmpsBundle\Entity\Partenaire',
        );
    }

    public function getName()
    {
        return 'partenaire';
    }

}
