<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends SecurityRepository
{

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CustomerEntity');
    }

}