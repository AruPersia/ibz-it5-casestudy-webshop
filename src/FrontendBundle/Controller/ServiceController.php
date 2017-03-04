<?php

namespace FrontendBundle\Controller;

use CoreBundle\Service\Db\CustomerService;
use CoreBundle\Service\Db\OrderService;
use CoreBundle\Service\Security\SecurityService;
use FrontendBundle\Service\Db\CategoryService;
use FrontendBundle\Service\Db\ProductService;
use FrontendBundle\Service\Db\RegistrationService;
use FrontendBundle\Service\ShoppingCart\DbShoppingCartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

abstract class ServiceController extends FormController
{

    protected function registrationService(): RegistrationService
    {
        return $this->get('frontend.service.db.registration');
    }

    protected function customerService(): CustomerService
    {
        return $this->get('frontend.service.db.customer');
    }

    protected function securityService(): SecurityService
    {
        return $this->get('frontend.service.db.security');
    }

    protected function productService(): ProductService
    {
        return $this->get('frontend.service.product');
    }

    protected function categoryService(): CategoryService
    {
        return $this->get('frontend.service.category');
    }

    protected function shoppingCartService(): DbShoppingCartService
    {
        return $this->get('frontend.service.shopping.cart');
    }

    protected function orderService(): OrderService
    {
        return $this->get('service.order');
    }

    /**
     * @return \FrontendBundle\Service\ShoppingCart\DbShoppingCartService
     */
    protected function getShoppingCartService()
    {
        return $this->get('frontend.service.shopping.cart');
    }

}
