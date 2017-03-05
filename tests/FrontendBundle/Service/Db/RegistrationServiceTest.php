<?php

namespace Tests\FrontendBundle\Service\Db;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FrontendBundle\Form\RegistrationData;
use FrontendBundle\Service\Db\RegistrationService;
use Tests\CoreBundle\Boot\TestWithDb;

class RegistrationServiceTest extends TestWithDb
{

    public function testSaveNewCustomerShouldBeSuccessful()
    {
        // given
        $registrationData = $this->createDefaultRegistrationData();
        $savedCustomerEntity = $this->customerService()->register($registrationData);

        // when
        $customerEntityFromDb = $this->customerService()->findByEmailAndPassword($registrationData->getEmail(), '123456');

        // then
        $this->assertNotNull($customerEntityFromDb);
        $this->assertEquals($savedCustomerEntity, $customerEntityFromDb);
    }

    private function createDefaultRegistrationData()
    {
        return RegistrationData::builder()
            ->setFirstName('Brad')
            ->setLastName('Pitt')
            ->setEmail('brad.pitt@eample.gmail.com')
            ->setPassword('123456');
    }

    public function testExceptionExpectedByDuplicatedEmailAddress()
    {
        // given
        $registrationData1 = $this->createDefaultRegistrationData();
        $registrationData2 = $this->createDefaultRegistrationData();

        // then & then
        $this->customerService()->register($registrationData1);
        $this->expectException(UniqueConstraintViolationException::class);
        $this->customerService()->register($registrationData2);
    }

}