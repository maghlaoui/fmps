<?php

namespace Acme\FmpsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterInscriptionEvent extends Event
{
  protected $inscription;

  public function __construct(\Acme\FmpsBundle\Entity\Inscription $inscription)
  {
    $this->inscription = $inscription;
  }

  public function getInscription()
  {
    return $this->inscription;
  }

}
