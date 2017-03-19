<?php
namespace FrontendBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Service\Db\CustomerMapper;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\AddressData;
use FrontendBundle\Form\CustomerData;
use FrontendBundle\Form\PasswordData;

class AccountService extends EntityService
{

    private $customerRepository;
    private $addressRepository;

    public function __construct(EntityManager $entityManager, CustomerRepository $customerRepository, AddressRepository $addressRepository)
    {
        parent::__construct($entityManager);
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
    }

    public function updatePersonalData($customerId, CustomerData $customerData): Customer
    {
        $customerEntity = $this->customerRepository->update($customerId, $customerData->getGender(), $customerData->getFirstName(), $customerData->getLastName(), $customerData->getEmail());
        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

    public function updateAddress($customerId, AddressData $addressData): Customer
    {
        $addressEntity = $this->addressRepository->create($addressData->getStreet(), $addressData->getHouseNumber(), $addressData->getPostCode(), $addressData->getCity());
        $customerEntity = $this->customerRepository->updateAddress($customerId, $addressEntity);
        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

    public function updatePassword($customerId, PasswordData $passwordData): Customer
    {
        $customerEntity = $this->customerRepository->updatePassword($customerId, $passwordData->getPassword());
        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

}