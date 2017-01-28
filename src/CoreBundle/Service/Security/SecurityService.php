<?php

namespace CoreBundle\Service\Security;

use CoreBundle\Form\InvalidFormException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityService
{
    private $request;
    private $tokenStorage;
    private $eventDispatcher;

    public function __construct(RequestStack $request, TokenStorage $tokenStorage, TraceableEventDispatcher $eventDispatcher)
    {
        $this->request = $request->getCurrentRequest();
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Form $form
     * @param SecurityRepositorySupport $securityRepository
     * @throws InvalidFormException
     */
    public function login(Form $form, SecurityRepositorySupport $securityRepository)
    {
        $form = $form->handleRequest($this->request);
        if (!$form->isValid()) {
            throw new InvalidFormException($form);
        }

        try {
            $user = $securityRepository->loadUserByEmailAndPassword($form->getData());
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'public', $user->getRoles());
            $this->tokenStorage->setToken($token);

            $event = new InteractiveLoginEvent($this->request, $token);
            $this->eventDispatcher->dispatch("security.interactive_login", $event);
        } catch (NoResultException $e) {
            $form->addError(new FormError('Wrong E-Mail or Password'));
            throw new InvalidFormException($form, $e);
        }
    }

    public function logout()
    {
        $this->tokenStorage->setToken(null);
    }
}