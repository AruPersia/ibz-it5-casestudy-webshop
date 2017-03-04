<?php
namespace FrontendBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Service\Db\CustomerMapper;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;
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

    public function create(RegistrationData $formData): Customer
    {
        $address = $formData->getAddressData();
        $addressEntity = $this->addressRepository->create($address->getStreet(), $address->getHouseNumber(), $address->getPostCode(), $address->getCity());

        $customerEntity = $this->customerRepository->create(
            $formData->getFirstName(),
            $formData->getLastName(),
            $formData->getEmail(),
            $formData->getPassword(),
            $addressEntity);

        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

}