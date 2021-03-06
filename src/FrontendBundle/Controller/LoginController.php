<?php

namespace FrontendBundle\Controller;

use FrontendBundle\Controller\Checkout\CheckoutController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class LoginController extends CategoryController
{

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->renderLoginForm($this->loginForm());
    }

    /**
     * @Route("/login/verify", name="login_verify")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        $loginForm = $this->loginForm()->handleRequest($this->getRequest());
        if ($loginForm->isValid()) {
            try {
                $this->securityService()->login($loginForm->getData());
                $this->resetCheckoutSteps();
                return $this->redirectToRoute('catalogue');
            } catch (\Exception $e) {
                $this->get('logger')->debug($e);
                $loginForm->addError(new FormError('Wrong email or password'));
            }
        }

        return $this->renderLoginForm($loginForm);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $this->securityService()->logout();
        $this->resetCheckoutSteps();
        return $this->redirectToRoute('login');
    }

    private function resetCheckoutSteps()
    {
        $this->getRequest()->getSession()->remove(CheckoutController::CHECKOUT_SESSION_KEY);
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Frontend/login.form.html.twig', ['loginForm' => $loginForm->createView()]);
    }

}