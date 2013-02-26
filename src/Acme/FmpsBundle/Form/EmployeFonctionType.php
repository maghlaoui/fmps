<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EmployeFonctionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $data = $options['data'];
        if($data && $data->getEmployeId() && $data->getId() == ''){
            $employe_id = $data->getEmployeId();
            $builder->add('employe', 'entity', array('class' => 'AcmeFmpsBundle:Employe', 'label' => 'Employe', 
                'query_builder' => function (EntityRepository $er) use ($employe_id)
                     {
                         return $er->createQueryBuilder('b')
                                ->where('b.id = ?1')
                                ->setParameter(1, $employe_id);
                     }
                     )); 
        }
        else{
            $builder->add('employe');
        }
        $builder
            ->add('fonction', 'entity', array('class' => 'AcmeFmpsBundle:Fonction', 'label' => 'Fonction'))
            ->add('dateDebutFonction', 'date', array('label' => 'Date de début', 'required' => true, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))
            ->add('dateFinFonction', 'date', array('label' => 'Date de fin', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date', 'placeholder' => 'JJ-MM-AAAA')))

        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EmployeFonction'
	    );
	  }

    public function getName()
    {
        return 'employe_fonction';
    }
}
