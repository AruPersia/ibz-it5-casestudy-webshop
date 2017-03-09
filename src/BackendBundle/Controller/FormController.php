<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ProductFormType;
use CoreBundle\Controller\CoreController;
use Symfony\Component\Form\Form;

class FormController extends CoreController
{

    public function productForm($data = null): Form
    {
        return $this->createForm(ProductFormType::class, $data);
    }

}