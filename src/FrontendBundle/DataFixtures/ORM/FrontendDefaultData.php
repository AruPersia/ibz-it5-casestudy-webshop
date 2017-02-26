<?php

namespace FrontendBundle\DataFixtures\ORM;

use CoreBundle\Entity\CategoryEntityBuilder;
use CoreBundle\Repository\CustomerRepository;
use CoreBundle\Util\PasswordUtil;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\RegistrationData;
use FrontendBundle\Service\Db\RegistrationService;

class FrontendDefaultData implements FixtureInterface
{

    /**
     * @var EntityManager
     */
    private $entityManger;

    private $customerRepository;

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
    }

    private function initServices()
    {
        $this->registrationService = new RegistrationService($this->entityManger, $this->customerRepository);
    }

    private function loadDefaultCustomer()
    {
        $defaultPassword = PasswordUtil::encrypt('123');
        $data = array();
        $data[] = $this->createRegistrationData('Brad', 'pitt', $defaultPassword);
        $data[] = $this->createRegistrationData('Tom', 'Hardy', $defaultPassword);
        $data[] = $this->createRegistrationData('Johnny', 'Depp', $defaultPassword);
        $data[] = $this->createRegistrationData('Donald', 'Trump', $defaultPassword);

        foreach ($data as $registrationData) {
            $this->registrationService->create($registrationData);
        }
    }

    private function createRegistrationData($firstName, $lastName, $password): RegistrationData
    {
        return RegistrationData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(strtolower($firstName . '.' . $lastName . '@localhost.local'))
            ->setPassword($password);
    }

}