<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\CreateProductFormType;
use BackendBundle\Form\UpdateProductFormType;
use CoreBundle\Controller\CoreController;
use Symfony\Component\Form\Form;

class FormController extends CoreController
{

    public function createProductForm($data = null): Form
    {
        return $this->createForm(CreateProductFormType::class, $data);
    }

    public function updateProductForm($data = null): Form
    {
        return $this->createForm(UpdateProductFormType::class, $data);
    }

}