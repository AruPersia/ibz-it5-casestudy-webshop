<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

class FormController extends Controller
{

    protected function loginForm(): Form
    {
        return $this->createForm(LoginFormType::class);
    }

}