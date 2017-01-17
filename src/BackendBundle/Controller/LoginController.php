<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\LoginFormType;
use CoreBundle\Message\Message;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends BackendController
{

    /**
     * @A\Route("/login", name="backendLogin")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        return $this->renderLoginForm($this->getLoginForm());
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Backend/login.form.html.twig', ['loginForm' => $loginForm->createView()]);
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getLoginForm()
    {
        return $this->createForm(LoginFormType::class);
    }

    /**
     * @A\Route("/login/signIn", name="backendLoginSignIn")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function signIn(Request $request)
    {
        $loginForm = $this->getLoginForm()->handleRequest($request);

        if ($loginForm->isValid()) {
            try {
                $admin = $this->getUserAuthenticationRepository()->loadUserByEmailAndPassword($loginForm->getData());
                $this->getAuthenticationService()->authenticate($request, $admin);
                return $this->redirectToRoute('backendShowDashboard');
            } catch (NoResultException $exception) {
                $loginForm->addError(new FormError('Wrong E-Mail or Password'));
            }
        }

        return $this->renderLoginForm($loginForm);
    }

    /**
     * @A\Route("/logout", name="backendLogout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        $this->addMessage(Message::success('logged.out.successful', 'Thanks for your visit'));
        return $this->redirectToRoute('backendShowDashboard');
    }

}