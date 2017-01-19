<?php

namespace BackendBundle\Controller;

use CoreBundle\Form\InvalidFormException;
use CoreBundle\Service\Security\SecurityControllerSupport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BackendController implements SecurityControllerSupport
{
    /**
     * @Route("/login")
     * @inheritdoc
     */
    public function loginAction()
    {
        return $this->renderLoginForm($this->getLoginForm());
    }

    private function renderLoginForm(Form $loginForm)
    {
        return $this->render('@Backend/login.form.html.twig', ['loginForm' => $loginForm->createView()]);
    }

    /**
     * @Route("/login/verify")
     * @inheritdoc
     */
    public function loginVerifyAction(Request $request)
    {
        try {
            $this->getSecurityService()->login($this->getLoginForm(), $this->getAdministratorRepository());
        } catch (InvalidFormException  $e) {
            return $this->renderLoginForm($e->getForm());
        }

        return $this->redirectToRoute('backend_dashboard_index');
    }

    /**
     * @Route("/logout")
     * @inheritdoc
     */
    public function logoutAction()
    {
        $this->getSecurityService()->logout();
        return $this->redirectToRoute('backend_dashboard_index');
    }


}