<?php

namespace Acme\FmpsBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Acme\StoreBundle\Entity\SuiviArgPart;

class SuiviArgPartListner
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof SuiviArgPart) {
            
        }
    }
}