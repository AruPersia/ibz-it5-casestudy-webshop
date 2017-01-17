<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\LoginData;
use BackendBundle\Form\LoginFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends BackendController
{

    /**
     * @A\Route("/login/signIn", name="backendLoginSignIn")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function signIn(Request $request)
    {
        $authenticationUtils = $this->getAuthenticationUtils();
        $authenticationException = $authenticationUtils->getLastAuthenticationError();

        $loginData = new LoginData();
        $loginData->setEmail($authenticationUtils->getLastUsername());

        $loginForm = $this->getLoginForm();
        $loginForm->setData($loginData);

        if ($authenticationException != null) {
            $loginForm->addError(new FormError($authenticationException->getMessage()));
        }

        return $this->renderLoginForm($loginForm);
    }

    /**
     * @return \Symfony\Component\Security\Http\Authentication\AuthenticationUtils
     */
    private function getAuthenticationUtils()
    {
        return $this->get('security.authentication_utils');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getLoginForm()
    {
        return $this->createForm(LoginFormType::class);
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Backend/login.form.html.twig', ['loginForm' => $loginForm->createView()]);
    }

    /**
     * @A\Route("/logout", name="backendLogout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        return $this->redirectToRoute('backendShowDashboard');
    }

}