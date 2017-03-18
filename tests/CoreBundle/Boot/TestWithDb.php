<?php
namespace Tests\CoreBundle\Boot;

use BackendBundle\Service\Db\AdministratorService;
use BackendBundle\Service\Db\ReorderService;
use CoreBundle\Service\Db\CategoryService;
use CoreBundle\Service\Db\CustomerService;
use CoreBundle\Service\Db\OrderService;
use CoreBundle\Service\Db\ProductService;
use CoreBundle\Service\Security\SecurityService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use FrontendBundle\Service\Db\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestWithDb extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    private $metadata;

    protected function administratorService(): AdministratorService
    {
        return $this->container->get('backend.service.administrator');
    }

    protected function backendSecurityService(): SecurityService
    {
        return $this->container->get('backend.service.db.security');
    }

    protected function categoryService(): CategoryService
    {
        return $this->container->get('service.category');
    }

    protected function productService(): ProductService
    {
        return $this->container->get('service.product');
    }

    protected function backendProductService(): \BackendBundle\Service\Db\ProductService
    {
        return $this->container->get('backend.service.product');
    }

    protected function customerService(): CustomerService
    {
        return $this->container->get('frontend.service.db.customer');
    }

    protected function registrationService(): RegistrationService
    {
        return $this->container->get('frontend.service.db.registration');
    }

    protected function orderService(): OrderService
    {
        return $this->container->get('service.order');
    }

    protected function frontendOrderService(): \FrontendBundle\Service\Db\OrderService
    {
        return $this->container->get('frontend.service.order');
    }

    protected function backendReorderService(): ReorderService
    {
        return $this->container->get('backend.service.reorder');
    }

    protected function setUp()
    {
        parent::setUp();
        parent::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getEntityManager();
        $this->schemaTool = new SchemaTool($this->em);
        $this->metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $this->dropTables();
        $this->createTables();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->dropTables();
        $this->em->close();
        unset($this->em);
    }

    private function dropTables()
    {
        $this->schemaTool->dropSchema($this->metadata);
    }

    private function createTables()
    {
        $this->schemaTool->createSchema($this->metadata);
    }

}