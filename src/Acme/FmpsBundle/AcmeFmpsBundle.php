<?php

namespace Acme\FmpsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeFmpsBundle extends Bundle
{
	
	public function getParent()
  {
     return 'FOSUserBundle';
  }
	
}
