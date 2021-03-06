<?php

namespace CoreBundle\Service\Security;

use CoreBundle\Form\LoginData;
use CoreBundle\Repository\SecurityRepository;
use CoreBundle\Util\PasswordUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityService
{
    private $requestStack;
    private $tokenStorage;
    private $eventDispatcher;
    private $securityRepository;

    public function __construct(RequestStack $requestStack, TokenStorage $tokenStorage, EventDispatcherInterface $eventDispatcher, SecurityRepository $securityRepository)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
        $this->securityRepository = $securityRepository;
    }

    public function login(LoginData $loginData)
    {
        $user = $this->securityRepository->loadUserByEmailAndPassword($loginData);
        PasswordUtil::verify($loginData->getPassword(), $user->getPassword());
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'public', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $event = new InteractiveLoginEvent($this->requestStack->getCurrentRequest(), $token);
        $this->eventDispatcher->dispatch("security.interactive_login", $event);
    }

    public function logout()
    {
        $this->tokenStorage->setToken(null);
    }
}