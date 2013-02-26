<?php
use Symfony\Component\Security\Core\SecurityContextInterface;

    namespace Acme\FmpsBundle\Services;

    class SecurityService { 

        protected $securityContext;

        public function __construct(SecurityContextInterface $securityContext)
        {
            $this->securityContext = $securityContext;
        }
    }