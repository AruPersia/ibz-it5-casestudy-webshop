<?php

namespace FrontendBundle\DataFixtures\ORM;

use CoreBundle\DataFixtures\ORM\AbstractFixtureInterface;
use CoreBundle\Model\OrderLineBuilder;
use CoreBundle\Util\PasswordUtil;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use FrontendBundle\Form\AddressData;
use FrontendBundle\Form\CustomerData;
use FrontendBundle\Form\PasswordData;
use FrontendBundle\Form\RegistrationData;

class FrontendDefaultData extends AbstractFixtureInterface implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    function loadData()
    {
        $this->createDefaultCustomer();
        $this->createDefaultOrders();
    }

    private function createDefaultCustomer()
    {
        $data = array();
        $password = PasswordUtil::encrypt('123');

        $data[] = $this->createRegistrationData('Brad', 'Pitt', $password);
        $data[] = $this->createRegistrationData('Tom', 'Hardy', $password);
        $data[] = $this->createRegistrationData('Johnny', 'Depp', $password);
        $data[] = $this->createRegistrationData('Donald', 'Trump', $password);

        foreach ($data as $registrationData) {
            $this->registrationService()->create($registrationData);
        }
    }

    private function createRegistrationData($firstName, $lastName, $password): RegistrationData
    {
        $customerData = CustomerData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(mb_strtolower($firstName . '.' . $lastName . '@localhost.local'));

        $passwordData = PasswordData::builder()->setPassword($password);

        $addressData = AddressData::builder()
            ->setStreet($firstName . $lastName . 'strasse')
            ->setHouseNumber('98B')
            ->setPostCode('8000')
            ->setCity('Zürich');

        return RegistrationData::builder()
            ->setCustomerData($customerData)
            ->setPasswordData($passwordData)
            ->setAddressData($addressData);
    }

    private function createDefaultOrders()
    {
        foreach ($this->backendCustomerService()->findAll() as $customer) {

            $orderLines = array();
            for ($i = 1; $i <= $customer->getId() * 3; $i++) {
                $product = $this->backendProductService()->findById($i);
                $orderLines[] = OrderLineBuilder::instance()
                    ->setProduct($product)
                    ->setQuantity($i)
                    ->build();
            }

            $this->frontendOrderService()->create($customer->getId(), $customer->getAddress(), $orderLines);
        }
    }

}