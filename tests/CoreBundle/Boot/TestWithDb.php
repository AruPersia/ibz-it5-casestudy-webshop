<?php
namespace Tests\CoreBundle\Boot;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestWithDb extends TestServices
{

    /**
     * @var EntityManager
     */
    protected $em;

    protected $container;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    private $metadata;

    function getContainer(): ContainerInterface
    {
        return $this->container;
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