<?php

namespace AdminBundle\Service;

use Doctrine\ORM\EntityManager;

class DbService
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
}