<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $data = $options['data'];
        if($data && $data->getPartenariatId() && $data->getId() == ''){
            $partenariat_id = $data->getPartenariatId();
            $builder->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat', 
                'query_builder' => function (EntityRepository $er) use ($partenariat_id)
                     {
                         return $er->createQueryBuilder('p')
                                ->where('p.id = ?1')
                                ->setParameter(1, $partenariat_id);
                     }
                     )); 
        }
        else{
            $builder->add('partenariat', 'entity', array('class' => 'AcmeFmpsBundle:Partenariat', 'label' => 'Partenariat')); 
        }
        $builder
            ->add('fichier', 'file', array('label' => 'Fichier', 'required' => true))
            ->add('type_document', 'entity', array('class' => 'AcmeFmpsBundle:TypeDocument', 'label' => 'Type du document'));
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Document'
	    );
	  }

    public function getName()
    {
        return 'document';
    }
}
