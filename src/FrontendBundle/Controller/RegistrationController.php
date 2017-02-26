<?php

namespace FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends CategoryController
{

    /**
     * @Route("/registration", name="registration")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->renderForm($this->registrationForm());
    }

    /**
     * @Route("registration/submit", name="registration_submit")
     */
    public function submit()
    {
        $registrationForm = $this->registrationForm()->handleRequest($this->getRequest());
        if (!$registrationForm->isValid()) {
            return $this->renderForm($registrationForm);
        }

        // FIXME AAF: Forward here would be a better choice
        $this->registrationService()->create($registrationForm->getData());
        return $this->render('@Frontend/base.html.twig');
    }

    private function renderForm(Form $form): Response
    {
        return $this->render('@Frontend/registration.form.html.twig', ['registrationForm' => $form->createView()]);
    }

}