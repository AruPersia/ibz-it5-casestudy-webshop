<?php

namespace FrontendBundle\Controller;

use CoreBundle\Controller\CoreController;
use FrontendBundle\Form\RegistrationFormType;
use Symfony\Component\Form\Form;

abstract class FormController extends CoreController
{

    protected function registrationForm(): Form
    {
        return $this->createForm(RegistrationFormType::class);
    }

}