<?php

namespace FrontendBundle\Controller;

use FrontendBundle\Service\Db\CategoryService;
use FrontendBundle\Service\Db\ProductService;
use FrontendBundle\Service\Db\RegistrationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

abstract class ServiceController extends FormController
{

    protected function productService(): ProductService
    {
        return $this->get('frontend.service.product');
    }

    protected function categoryService(): CategoryService
    {
        return $this->get('frontend.service.category');
    }

    protected function registrationService(): RegistrationService
    {
        return $this->get('frontend.service.db.registration');
    }

    /**
     * @return \FrontendBundle\Service\ShoppingCart\DbShoppingCartService
     */
    protected function getShoppingCartService()
    {
        return $this->get('frontend.service.shopping.cart');
    }

}
