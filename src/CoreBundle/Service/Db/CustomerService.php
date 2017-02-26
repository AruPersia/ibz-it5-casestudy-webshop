<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\CustomerRepository;
use Doctrine\ORM\EntityManager;

class CustomerService extends EntityService
{
    private $customerRepository;

    public function __construct(EntityManager $entityManager, CustomerRepository $customerRepository)
    {
        parent::__construct($entityManager);
        $this->customerRepository = $customerRepository;
    }

    public function create(Customer $customer, $password): Customer
    {
        $this->customerRepository->create($customer->getFirstName(), $customer->getLastName(), $customer->getEmail(), $password);
    }

}