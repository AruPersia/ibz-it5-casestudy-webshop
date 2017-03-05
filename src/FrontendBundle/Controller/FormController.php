<?php

namespace FrontendBundle\Controller;

use CoreBundle\Controller\CoreController;
use CoreBundle\Form\LoginFormType;
use CoreBundle\Form\PersonalFormType;
use FrontendBundle\Form\AddressEditFormType;
use FrontendBundle\Form\AddressFormType;
use FrontendBundle\Form\CustomerEditFormType;
use FrontendBundle\Form\CustomerFormType;
use FrontendBundle\Form\RegistrationFormType;
use Symfony\Component\Form\Form;

abstract class FormController extends CoreController
{

    protected function customerForm(): Form
    {
        return $this->createForm(CustomerFormType::class);
    }

    protected function customerEditForm(): Form
    {
        return $this->createForm(CustomerEditFormType::class);
    }

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

    protected function addressEditForm(): Form
    {
        return $this->createForm(AddressEditFormType::class);
    }

}