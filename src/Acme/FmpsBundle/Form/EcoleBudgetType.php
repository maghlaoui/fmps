<?php

namespace Acme\FmpsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Acme\FmpsBundle\Util\FmpsLists;
use Doctrine\ORM\EntityRepository;

class EcoleBudgetType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
				$user = $options['user'];
				$ecoles = implode(', ', $user->getEcoles());
        $builder
					  ->add('budget', 'entity', array('class' => 'AcmeFmpsBundle:Budget', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) use ($ecoles)
                     {
                         return $er->createQueryBuilder('b')
                                ->where("b.id IN (SELECT eb.budgetId FROM AcmeFmpsBundle:EcoleBudget eb WHERE  eb.ecoleId in ($ecoles) )");
                     }
                     ))
            ->add('ecole', 'entity', array('class' => 'AcmeFmpsBundle:Ecole', 'label' => 'Ecole', 
                'query_builder' => function (EntityRepository $er) 
                     {
                         return $er->createQueryBuilder('e')
                                ->where('e.id > 1');
                     }
                     ))
        ;
    }

	  public function getDefaultOptions(array $options)
	  {
	    return array(
	      'data_class' => 'Acme\FmpsBundle\Entity\EcoleBudget',
	      'user' => null
	    );
	  }

    public function getName()
    {
        return 'ecole_budget';
    }
}
