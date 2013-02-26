<?php

namespace Acme\FmpsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterAffectationEvent extends Event
{
  protected $affectation;

  public function __construct(\Acme\FmpsBundle\Entity\Affectation $affectation)
  {
    $this->affectation = $affectation;
  }

  public function getAffectation() {
    return $this->affectation;
  }
}
