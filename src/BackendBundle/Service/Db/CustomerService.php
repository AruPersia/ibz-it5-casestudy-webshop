<?php

namespace BackendBundle\Service\Db;

use CoreBundle\Service\Db\CustomerMapper;
use CoreBundle\Service\Db\EntityManagerService;

class CustomerService extends \CoreBundle\Service\Db\CustomerService
{

    /**
     * @return \CoreBundle\Model\Customer[]
     */
    public function findAll()
    {
        return CustomerMapper::mapToCustomers($this->customerRepository->findAll());
    }

}