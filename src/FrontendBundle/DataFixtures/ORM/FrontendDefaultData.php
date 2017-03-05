<?php

namespace FrontendBundle\DataFixtures\ORM;

use CoreBundle\Entity\CategoryEntityBuilder;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Util\PasswordUtil;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\AddressData;
use FrontendBundle\Form\CustomerWithPwData;
use FrontendBundle\Form\RegistrationData;
use FrontendBundle\Service\Db\RegistrationService;

class FrontendDefaultData implements FixtureInterface
{

    /**
     * @var EntityManager
     */
    private $entityManger;

    private $customerRepository;
    private $addressRepository;

    /**
     * @var RegistrationService
     */
    private $registrationService;


    public function load(ObjectManager $manager)
    {
        $this->entityManger = $manager;
        $this->initRepositories();
        $this->initServices();
        $this->loadDefaultCustomer();
    }

    private function initRepositories()
    {
        $this->customerRepository = new CustomerRepository($this->entityManger);
        $this->addressRepository = new AddressRepository($this->entityManger);
    }

    private function initServices()
    {
        $this->registrationService = new RegistrationService($this->entityManger, $this->customerRepository, $this->addressRepository);
    }

    private function loadDefaultCustomer()
    {
        $data = array();
        $password = PasswordUtil::encrypt('123');
        $addressData = AddressData::builder()
            ->setStreet('Talackerstrasse')
            ->setHouseNumber('45H')
            ->setPostCode('3604')
            ->setCity('Thun');

        $data[] = $this->createRegistrationData('Brad', 'pitt', $password, $addressData);
        $data[] = $this->createRegistrationData('Tom', 'Hardy', $password, $addressData);
        $data[] = $this->createRegistrationData('Johnny', 'Depp', $password, $addressData);
        $data[] = $this->createRegistrationData('Donald', 'Trump', $password, $addressData);

        foreach ($data as $registrationData) {
            $this->registrationService->create($registrationData);
        }
    }

    private function createRegistrationData($firstName, $lastName, $password, $addressData): RegistrationData
    {
        $customerData = CustomerWithPwData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(strtolower($firstName . '.' . $lastName . '@localhost.local'))
            ->setPassword($password);

        return RegistrationData::builder()
            ->setCustomerWithPwData($customerData)
            ->setAddressData($addressData);
    }

}