<?php
namespace FrontendBundle\Service\Db;

use CoreBundle\Model\Customer;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Service\Db\CustomerMapper;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\RegistrationData;

class RegistrationService extends EntityService
{

    private $customerRepository;

    public function __construct(EntityManager $entityManager, CustomerRepository $customerRepository)
    {
        parent::__construct($entityManager);
        $this->customerRepository = $customerRepository;
    }

    public function create(RegistrationData $formData): Customer
    {
        $customerEntity = $this->customerRepository->create(
            $formData->getFirstName(),
            $formData->getLastName(),
            $formData->getEmail(),
            $formData->getPassword());

        $this->flush();
        return CustomerMapper::mapToCustomer($customerEntity);
    }

}