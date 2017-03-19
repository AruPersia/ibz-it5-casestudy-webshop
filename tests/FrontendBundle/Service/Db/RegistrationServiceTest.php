<?php

namespace Tests\FrontendBundle\Service\Db;


use CoreBundle\Util\PasswordUtil;
use FrontendBundle\Form\AddressData;
use FrontendBundle\Form\CustomerData;
use FrontendBundle\Form\PasswordData;
use FrontendBundle\Form\RegistrationData;
use Tests\CoreBundle\Boot\TestWithDb;

class RegistrationServiceTest extends TestWithDb
{

    public function testCreateCustomerShouldWorkProperly()
    {
        // given
        $registrationData = $this->createDefaultRegistrationData();
        $customerData = $registrationData->getCustomerData();
        $addressData = $registrationData->getAddressData();

        // when
        $customer = $this->registrationService()->create($registrationData);

        // then
        $this->assertEquals($customerData->getFirstName(), $customer->getFirstName());
        $this->assertEquals($customerData->getLastName(), $customer->getLastName());
        $this->assertEquals($customerData->getEmail(), $customer->getEmail());
        $this->assertEquals($addressData->getStreet(), $customer->getAddress()->getStreet());
        $this->assertEquals($addressData->getHouseNumber(), $customer->getAddress()->getHouseNumber());
        $this->assertEquals($addressData->getPostCode(), $customer->getAddress()->getPostCode());
        $this->assertEquals($addressData->getCity(), $customer->getAddress()->getCity());
    }

    private function createDefaultRegistrationData()
    {
        $firstName = uniqid();
        $lastName = uniqid();
        $passwordData = PasswordData::builder()->setPassword(PasswordUtil::encrypt('123'));
        $customerData = CustomerData::builder()
            ->setGender('m')
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(sprintf('%s.%s@example.local', $firstName, $lastName));
        $addressData = AddressData::builder()
            ->setStreet(sprintf('%s-street', $firstName))
            ->setHouseNumber(33)
            ->setPostCode('8000')
            ->setCity('Zürich');

        return RegistrationData::builder()
            ->setCustomerData($customerData)
            ->setPasswordData($passwordData)
            ->setAddressData($addressData);
    }

}