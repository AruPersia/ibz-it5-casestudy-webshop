<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Util\ValidateUtil;
use Doctrine\ORM\EntityManager;

class EntityService
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        ValidateUtil::notNull($entityManager);
        $this->entityManager = $entityManager;
    }

    protected function flush()
    {
        $this->entityManager->flush();
    }

}