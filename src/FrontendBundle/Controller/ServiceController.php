<?php

namespace FrontendBundle\Controller;

use CoreBundle\Service\Db\CustomerService;
use CoreBundle\Service\Db\ProductService;
use CoreBundle\Service\Security\SecurityService;
use FrontendBundle\Service\Db\AccountService;
use FrontendBundle\Service\Db\CategoryService;
use FrontendBundle\Service\Db\OrderService;
use FrontendBundle\Service\Db\RegistrationService;
use FrontendBundle\Service\ShoppingCart\DbShoppingCartService;
use FrontendBundle\Twig\Extension\CurrencyService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

abstract class ServiceController extends FormController
{

    protected function registrationService(): RegistrationService
    {
        return $this->get('frontend.service.db.registration');
    }

    protected function profileService(): AccountService
    {
        return $this->get('frontend.service.db.profile');
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
        return $this->get('service.product');
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
        return $this->get('frontend.service.order');
    }

    protected function currencyService(): CurrencyService
    {
        return $this->get('frontend.service.currency');
    }

    /**
     * @return \FrontendBundle\Service\ShoppingCart\DbShoppingCartService
     */
    protected function getShoppingCartService()
    {
        return $this->get('frontend.service.shopping.cart');
    }

}
