<?php
namespace Tests\CoreBundle\Boot;

use BackendBundle\DataFixtures\ORM\BackendDefaultData;
use FrontendBundle\DataFixtures\ORM\FrontendDefaultData;

class TestWebWithDbDefaultData extends TestWithDb
{
    protected static function createClient(array $options = array(), array $server = array())
    {
        static::bootKernel($options);

        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

    protected function setUp()
    {
        parent::setUp();
        (new BackendDefaultData())->load($this->em);
        (new FrontendDefaultData())->load($this->em);
    }

}