<?php

namespace CoreBundle\Service\Security;

use CoreBundle\Entity\UserAuthentication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserAuthenticationService
{
    private $tokenStorage;
    private $eventDispatcher;

    public function __construct(TokenStorage $tokenStorage, TraceableEventDispatcher $eventDispatcher)
    {
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function authenticate(Request $request, UserAuthentication $userAuthentication)
    {
        $token = new UsernamePasswordToken($userAuthentication, $userAuthentication->getPassword(), 'public', $userAuthentication->getRoles());
        $this->tokenStorage->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch("security.interactive_login", $event);
    }
}