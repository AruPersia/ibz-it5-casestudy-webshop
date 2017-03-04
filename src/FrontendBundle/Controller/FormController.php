<?php

namespace FrontendBundle\Controller;

use CoreBundle\Controller\CoreController;
use CoreBundle\Form\AddressFormType;
use CoreBundle\Form\LoginFormType;
use CoreBundle\Form\PersonalFormType;
use FrontendBundle\Form\RegistrationFormType;
use Symfony\Component\Form\Form;

abstract class FormController extends CoreController
{

    protected function registrationForm(): Form
    {
        return $this->createForm(RegistrationFormType::class);
    }

    protected function loginForm(): Form
    {
        return $this->createForm(LoginFormType::class);
    }

    protected function personalForm(): Form
    {
        return $this->createForm(PersonalFormType::class);
    }

    protected function addressForm(): Form
    {
        return $this->createForm(AddressFormType::class);
    }

}