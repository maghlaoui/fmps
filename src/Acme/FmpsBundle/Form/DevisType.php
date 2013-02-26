<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $data = $options['data'];
        if($data && $data->getBonCommandeId() && $data->getId() == ''){
            $bon_commande_id = $data->getBonCommandeId();
            $builder->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande', 
                'query_builder' => function (EntityRepository $er) use ($bon_commande_id)
                     {
                         return $er->createQueryBuilder('b')
                                ->where('b.id = ?1')
                                ->setParameter(1, $bon_commande_id);
                     }
                     )); 
        }
        else{
            $builder->add('bonCommande', 'entity', array('class' => 'AcmeFmpsBundle:BonCommande', 'label' => 'Bon de commande'));
        }
        $builder
            ->add('fichier', 'file')
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\Devis'
	    );
	  }

    public function getName()
    {
        return 'devis';
    }
}
