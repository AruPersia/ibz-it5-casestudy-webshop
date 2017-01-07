<?php
namespace AppBundle\Service\Db;

use Doctrine\ORM\EntityManager;

class DbBaseService
{

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

}