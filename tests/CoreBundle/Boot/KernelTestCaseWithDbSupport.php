<?php
namespace Tests\CoreBundle\Boot;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class KernelTestCaseWithDbSupport extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    private $metadata;

    protected function setUp()
    {
        parent::setUp();
        parent::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getEntityManager();
        $this->schemaTool = new SchemaTool($this->em);
        $this->metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $this->dropTables();
        $this->createTables();
    }

    private function dropTables()
    {
        $this->schemaTool->dropSchema($this->metadata);
    }

    private function createTables()
    {
        $this->schemaTool->createSchema($this->metadata);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->dropTables();
        $this->em->close();
        unset($this->em);
    }

}