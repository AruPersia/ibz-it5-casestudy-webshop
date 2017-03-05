<?php

namespace CoreBundle\DataFixtures\ORM;

use BackendBundle\Service\Db\CategoryService;
use BackendBundle\Service\Db\CustomerService;
use BackendBundle\Service\Db\ProductService;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\OrderRepository;
use CoreBundle\Repository\ProductRepository;
use CoreBundle\Service\Db\OrderService;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Service\Db\RegistrationService;

abstract class AbstractFixtureInterface implements FixtureInterface, OrderedFixtureInterface
{
    // Repositories
    private $entityManger;
    private $productRepository;
    private $categoryRepository;
    private $imageRepository;
    private $customerRepository;
    private $addressRepository;
    private $orderRepository;

    // Services
    private $categoryService;
    private $productService;
    private $registrationService;
    private $backendCustomerService;
    private $orderService;

    public function load(ObjectManager $manager)
    {
        $this->entityManger = $manager;
        $this->initRepositories();
        $this->initServices();
        $this->loadData();
    }

    abstract function loadData();

    protected function entityManger(): EntityManager
    {
        return $this->entityManger();
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

    protected function productService(): ProductService
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

    protected function orderService(): OrderService
    {
        return $this->orderService;
    }

    private function initRepositories()
    {
        $this->productRepository = new ProductRepository($this->entityManger);
        $this->categoryRepository = new CategoryRepository($this->entityManger);
        $this->imageRepository = new ImageRepository($this->entityManger);
        $this->customerRepository = new CustomerRepository($this->entityManger);
        $this->addressRepository = new AddressRepository($this->entityManger);
        $this->orderRepository = new OrderRepository($this->entityManger);
    }

    private function initServices()
    {
        $this->productService = new ProductService($this->entityManger, $this->productRepository, $this->categoryRepository, $this->imageRepository);
        $this->categoryService = new CategoryService($this->entityManger, $this->categoryRepository);
        $this->registrationService = new RegistrationService($this->entityManger, $this->customerRepository, $this->addressRepository);
        $this->backendCustomerService = new CustomerService($this->entityManger, $this->customerRepository, $this->addressRepository);
        $this->orderService = new OrderService($this->entityManger, $this->orderRepository, $this->addressRepository);
    }

}