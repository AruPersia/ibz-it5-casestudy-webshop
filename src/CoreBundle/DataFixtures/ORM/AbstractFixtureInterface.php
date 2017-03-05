<?php

namespace CoreBundle\DataFixtures\ORM;

use BackendBundle\Service\Db\AdministratorService;
use BackendBundle\Service\Db\CategoryService;
use BackendBundle\Service\Db\CustomerService;
use BackendBundle\Service\Db\ProductService;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\AdministratorRepository;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\OrderRepository;
use CoreBundle\Repository\ProductRepository;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Service\Db\OrderService;
use FrontendBundle\Service\Db\RegistrationService;

abstract class AbstractFixtureInterface implements FixtureInterface, OrderedFixtureInterface
{
    private $entityManger;

    // Repositories
    private $administratorRepository;
    private $productRepository;
    private $categoryRepository;
    private $imageRepository;
    private $customerRepository;
    private $addressRepository;
    private $orderRepository;

    // Services
    private $administratorService;
    private $categoryService;
    private $productService;
    private $registrationService;
    private $backendCustomerService;
    private $frontendOrderService;
    private $backendOrderService;

    public function load(ObjectManager $manager)
    {
        $this->entityManger = $manager;
        $this->initRepositories();
        $this->initServices();
        $this->loadData();
    }

    abstract function loadData();

    public function administratorRepository(): AdministratorRepository
    {
        return $this->administratorRepository;
    }

    public function administratorService(): AdministratorService
    {
        return $this->administratorService;
    }

    protected function entityManger(): EntityManager
    {
        return $this->entityManger;
    }

    protected function productRepository(): ProductRepository
    {
        return $this->productRepository;
    }

    protected function categoryRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

    protected function imageRepository(): ImageRepository
    {
        return $this->imageRepository;
    }

    protected function categoryService(): CategoryService
    {
        return $this->categoryService;
    }

    protected function backendProductService(): ProductService
    {
        return $this->productService;
    }

    protected function registrationService(): RegistrationService
    {
        return $this->registrationService;
    }

    protected function backendCustomerService(): CustomerService
    {
        return $this->backendCustomerService;
    }

    protected function frontendOrderService(): OrderService
    {
        return $this->frontendOrderService;
    }

    protected function backendOrderService(): \BackendBundle\Service\Db\OrderService
    {
        return $this->backendOrderService;
    }

    private function initRepositories()
    {
        $this->administratorRepository = new AdministratorRepository($this->entityManger);
        $this->productRepository = new ProductRepository($this->entityManger);
        $this->categoryRepository = new CategoryRepository($this->entityManger);
        $this->imageRepository = new ImageRepository($this->entityManger);
        $this->customerRepository = new CustomerRepository($this->entityManger);
        $this->addressRepository = new AddressRepository($this->entityManger);
        $this->orderRepository = new OrderRepository($this->entityManger);
    }

    private function initServices()
    {
        $this->administratorService = new AdministratorService($this->entityManger, $this->administratorRepository);
        $this->productService = new ProductService($this->entityManger, $this->productRepository, $this->categoryRepository, $this->imageRepository);
        $this->categoryService = new CategoryService($this->entityManger, $this->categoryRepository);
        $this->registrationService = new RegistrationService($this->entityManger, $this->customerRepository, $this->addressRepository);
        $this->backendCustomerService = new CustomerService($this->entityManger, $this->customerRepository, $this->addressRepository);
        $this->frontendOrderService = new \FrontendBundle\Service\Db\OrderService($this->entityManger, $this->orderRepository, $this->addressRepository);
        $this->backendOrderService = new \BackendBundle\Service\Db\OrderService($this->entityManger, $this->orderRepository, $this->addressRepository);
    }

}