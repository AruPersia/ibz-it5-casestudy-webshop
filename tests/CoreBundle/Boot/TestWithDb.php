<?php
namespace Tests\CoreBundle\Boot;

use CoreBundle\Service\Db\CategoryService;
use CoreBundle\Service\Db\CustomerService;
use CoreBundle\Service\Db\OrderService;
use CoreBundle\Service\Db\ProductService;
use CoreBundle\Service\Db\StockService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
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

    protected function categoryService(): CategoryService
    {
        return $this->container->get('service.category');
    }

    protected function productService(): ProductService
    {
        return $this->container->get('service.product');
    }

    protected function customerService(): CustomerService
    {
        return $this->container->get('frontend.service.db.customer');
    }

    protected function orderService(): OrderService
    {
        return $this->container->get('service.order');
    }

    protected function stockService(): StockService
    {
        return $this->container->get('service.stock');
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