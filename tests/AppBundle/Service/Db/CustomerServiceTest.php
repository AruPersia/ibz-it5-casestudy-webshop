<?php

namespace Tests\AppBundle\Service\Db;


use AppBundle\Entity\CustomerEntity;
use AppBundle\Service\Db\CustomerService;
use AppBundle\Util\PasswordUtil;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Tests\AppBundle\Boot\KernelTestCaseWithDbSupport;

class CustomerServiceTest extends KernelTestCaseWithDbSupport
{

    public function testSaveNewCustomerShouldBeSuccessful()
    {
        // given
        $customerEntity = $this->createDefaultCustomer();
        $this->customerService()->save($customerEntity);

        // when
        $savedCustomerEntity = $this->customerService()->findByEmailAndPassword($customerEntity->getEmail(), '123456');

        // then
        $this->assertNotNull($savedCustomerEntity);
        $this->assertEquals($customerEntity, $savedCustomerEntity);
    }

    private function createDefaultCustomer()
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setFirstName('Brad');
        $customerEntity->setLastName('Pitt');
        $customerEntity->setEmail('brad.pitt@gmail.com');
        $customerEntity->setPassword(PasswordUtil::encrypt('123456'));
        return $customerEntity;
    }

    /**
     * @return CustomerService
     */
    private function customerService()
    {
        return static::$kernel->getContainer()->get('services.db.customer');
    }

    public function testExceptionExpectedByDuplicatedEmailAddress()
    {
        // given
        $customerEntity = $this->createDefaultCustomer();
        $this->customerService()->save($customerEntity);
        $customerEntity = $this->createDefaultCustomer();

        // then & then
        $this->expectException(UniqueConstraintViolationException::class);
        $this->customerService()->save($customerEntity);
    }

}