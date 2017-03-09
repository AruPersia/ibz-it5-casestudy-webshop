<?php

namespace BackendBundle\Controller;

use CoreBundle\Util\PasswordHashDoesNotMatchException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class LoginController extends ServiceController
{

    /**
     * @Route("/login", name="backend_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        return $this->renderLoginForm($this->loginForm());
    }

    /**
     * @Route("/login/submit", name="backend_submit_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitLogin()
    {
        $loginForm = $this->loginForm()->handleRequest($this->getRequest());
        if ($loginForm->isValid()) {
            try {
                $this->securityService()->login($loginForm->getData());
                // TODO AAF render to right class
            } catch (NoResultException | PasswordHashDoesNotMatchException $e) {
                $this->get('logger')->debug($e);
                $loginForm->addError(new FormError('Wrong email or password'));
            }
        }

        return $this->redirectToRoute('backend_dashboard');
    }

    /**
     * @Route("/logout", name="backend_logout")
     */
    public function logout()
    {
        $this->securityService()->logout();
        return $this->redirectToRoute('backend_login');
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Backend/login.form.html.twig', ['loginForm' => $loginForm->createView()]);
    }

}