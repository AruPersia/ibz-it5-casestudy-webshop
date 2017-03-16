<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Util\PasswordUtil;
use Doctrine\ORM\EntityManager;

class CustomerService extends EntityService
{

    protected $customerRepository;
    protected $addressRepository;

    public function __construct(EntityManager $entityManager, CustomerRepository $customerRepository, AddressRepository $addressRepository)
    {
        parent::__construct($entityManager);
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
    }

    public function create(Customer $customer, $password): Customer
    {
        $address = $customer->getAddress();
        $addressEntity = $this->addressRepository->create($address->getStreet(), $address->getHouseNumber(), $address->getPostCode(), $address->getCity());
        $customerEntity = $this->customerRepository->create($customer->getFirstName(), $customer->getLastName(), $customer->getEmail(), $password, $addressEntity);
        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

    public function findOrCreate(Customer $customer): Customer
    {
        $customerEntity = $this->customerRepository->findCustomer($customer->getFirstName(), $customer->getLastName(), $customer->getEmail());

        if ($customerEntity == null) {
            $customer = $this->create($customer, PasswordUtil::encrypt(uniqid()));
            return $customer;
        }

        return CustomerMapper::mapToCustomer($customerEntity);
    }

    public function findById($id): Customer
    {
        return CustomerMapper::mapToCustomer($this->customerRepository->findById($id));
    }

}