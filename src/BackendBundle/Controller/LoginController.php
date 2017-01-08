<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\LoginFormType;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends BackendController
{

    /**
     * @A\Route("/login", name="adminLogin")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        return $this->renderLoginForm($this->getLoginForm());
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Backend/Login/login.html.twig', ['loginForm' => $loginForm->createView()]);
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getLoginForm()
    {
        return $this->createForm(LoginFormType::class);
    }

    /**
     * @A\Route("/login/signIn", name="adminLoginSignIn")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function signIn(Request $request)
    {
        $loginForm = $this->getLoginForm()->handleRequest($request);
        if ($loginForm->isValid()) {
            $adminEntity = $this->loginService()->findByEmailAndPassword($loginForm->getData());
            if ($adminEntity != null) {
                $this->addMessage(Message::success('login.successful', 'your.login.was.successful'));
                return $this->render('@Backend/Dashboard/dashboard.html.twig');
            } else {
                $this->addMessage(Message::danger('login.failed', 'email.or.password.wrong'));
            }
        }

        return $this->renderLoginForm($loginForm);
    }

}