<?php
namespace Tests\CoreBundle\Boot;

use BackendBundle\DataFixtures\ORM\BackendDefaultData;
use FrontendBundle\DataFixtures\ORM\FrontendDefaultData;

class TestWithDbDefaultData extends TestWithDb
{
    protected function setUp()
    {
        parent::setUp();
        (new BackendDefaultData())->load($this->em);
        (new FrontendDefaultData())->load($this->em);
    }

}