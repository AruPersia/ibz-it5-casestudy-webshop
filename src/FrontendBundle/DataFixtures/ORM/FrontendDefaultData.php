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
use FrontendBundle\Form\CustomerData;
use FrontendBundle\Form\CustomerWithPwData;
use FrontendBundle\Form\PasswordData;
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

        $data[] = $this->createRegistrationData('Brad', 'Pitt', $password);
        $data[] = $this->createRegistrationData('Tom', 'Hardy', $password);
        $data[] = $this->createRegistrationData('Johnny', 'Depp', $password);
        $data[] = $this->createRegistrationData('Donald', 'Trump', $password);

        foreach ($data as $registrationData) {
            $this->registrationService->create($registrationData);
        }
    }

    private function createRegistrationData($firstName, $lastName, $password): RegistrationData
    {
        $customerData = CustomerData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(strtolower($firstName . '.' . $lastName . '@localhost.local'));

        $passwordData = PasswordData::builder()->setPassword($password);

        $addressData = AddressData::builder()
            ->setStreet(ucfirst(strtolower($firstName . $lastName . 'strasse')))
            ->setHouseNumber('98B')
            ->setPostCode('8000')
            ->setCity('Zürich');

        return RegistrationData::builder()
            ->setCustomerData($customerData)
            ->setPasswordData($passwordData)
            ->setAddressData($addressData);
    }

}