<?php
namespace Tests\CoreBundle\Boot;

use BackendBundle\Service\Db\AdministratorService;
use BackendBundle\Service\Db\ReorderService;
use CoreBundle\Service\Db\CategoryService;
use CoreBundle\Service\Db\CustomerService;
use CoreBundle\Service\Db\OrderService;
use CoreBundle\Service\Db\ProductService;
use CoreBundle\Service\Security\SecurityService;
use FrontendBundle\Service\Db\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TestServices extends KernelTestCase
{

    abstract function getContainer(): ContainerInterface;

    protected function administratorService(): AdministratorService
    {
        return $this->getContainer()->get('backend.service.administrator');
    }

    protected function backendSecurityService(): SecurityService
    {
        return $this->getContainer()->get('backend.service.db.security');
    }

    protected function categoryService(): CategoryService
    {
        return $this->getContainer()->get('service.category');
    }

    protected function productService(): ProductService
    {
        return $this->getContainer()->get('service.product');
    }

    protected function backendProductService(): \BackendBundle\Service\Db\ProductService
    {
        return $this->getContainer()->get('backend.service.product');
    }

    protected function customerService(): CustomerService
    {
        return $this->getContainer()->get('frontend.service.db.customer');
    }

    protected function registrationService(): RegistrationService
    {
        return $this->getContainer()->get('frontend.service.db.registration');
    }

    protected function orderService(): OrderService
    {
        return $this->getContainer()->get('service.order');
    }

    protected function frontendOrderService(): \FrontendBundle\Service\Db\OrderService
    {
        return $this->getContainer()->get('frontend.service.order');
    }

    protected function backendReorderService(): ReorderService
    {
        return $this->getContainer()->get('backend.service.reorder');
    }

}