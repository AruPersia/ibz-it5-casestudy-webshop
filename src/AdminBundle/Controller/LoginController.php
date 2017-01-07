<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\LoginFormType;
use Core\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AdminController
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
        return $this->render('@Admin/Login/login.html.twig', ['loginForm' => $loginForm->createView()]);
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
                return $this->render('@Admin/Dashboard/dashboard.html.twig');
            } else {
                $this->addMessage(Message::danger('login.failed', 'email.or.password.wrong'));
            }
        }

        return $this->renderLoginForm($loginForm);
    }

}