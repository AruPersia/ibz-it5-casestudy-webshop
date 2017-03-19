<?php
namespace FrontendBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Service\Db\CustomerMapper;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\CustomerData;
use FrontendBundle\Form\RegistrationData;

class RegistrationService extends EntityService
{

    private $customerRepository;
    private $addressRepository;

    public function __construct(EntityManager $entityManager, CustomerRepository $customerRepository, AddressRepository $addressRepository)
    {
        parent::__construct($entityManager);
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
    }

    public function create(RegistrationData $registrationData): Customer
    {
        $customerData = $registrationData->getCustomerData();
        $passwordData = $registrationData->getPasswordData();
        $addressData = $registrationData->getAddressData();

        $addressEntity = $this->addressRepository->create($addressData->getStreet(), $addressData->getHouseNumber(), $addressData->getPostCode(), $addressData->getCity());

        $customerEntity = $this->customerRepository->create(
            $customerData->getGender(),
            $customerData->getFirstName(),
            $customerData->getLastName(),
            $customerData->getEmail(),
            $passwordData->getPassword(),
            $addressEntity);

        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

    public function update($customerId, CustomerData $customerData): Customer
    {
        $customerEntity = $this->customerRepository->findById($customerId);
        $customerEntity->setFirstName($customerData->getFirstName());
        $customerEntity->setLastName($customerData->getLastName());
        $customerEntity->setEmail($customerData->getEmail());
    }

}