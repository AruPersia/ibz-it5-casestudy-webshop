<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\UserEntity;
use BackendBundle\Form\LoginData;
use BackendBundle\Form\LoginFormType;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;

class LoginController extends BackendController
{

    /**
     * @A\Route("/login/signIn", name="backendLoginSignIn")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function signIn()
    {
        $user = new UserEntity();
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'admin');
        $afs = 'test';

        $authenticationUtils = $this->getAuthenticationUtils();
        $email = $authenticationUtils->getLastUsername();

        $loginData = new LoginData();
        $loginData->setEmail($email);
        $loginForm = $this->getLoginForm();
        $loginForm->setData($loginData);

        $errorMessage = $authenticationUtils->getLastAuthenticationError();
        if ($errorMessage != null) {
            $this->addMessage(Message::info('login.failed', $errorMessage->getMessage()));
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