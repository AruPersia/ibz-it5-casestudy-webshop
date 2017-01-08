<?php

namespace CoreBundle\Service\Db;

use Doctrine\ORM\EntityManager;

class EntityManagerService
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
}