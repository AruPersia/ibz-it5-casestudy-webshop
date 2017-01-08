<?php

namespace Tests\BackendBundle\Service\Db;

use BackendBundle\Entity\UserEntity;
use BackendBundle\Form\LoginData;
use CoreBundle\Util\PasswordUtil;
use Tests\CoreBundle\Boot\KernelTestCaseWithDbSupport;

class LoginServiceTest extends KernelTestCaseWithDbSupport
{

    public function testLoginShouldNotBeSuccessful()
    {
        // given
        $this->persistDefaultUsers();
        $loginData = $this->createLoginData('some@email.com', '123456');

        // when
        $result = $this->getLoginService()->findByEmailAndPassword($loginData);

        // then
        $this->assertNull($result);
    }

    private function persistDefaultUsers()
    {
        $this->em->persist($this->createUserEntity('Brad', 'Pitt', 'brad.pitt@example.com', '123456'));
        $this->em->persist($this->createUserEntity('Brad2', 'Pitt2', 'brad2.pitt2@example.com', '654321'));
        $this->em->flush();
    }

    private function createUserEntity(String $firstName, String $lastName, String $email, String $password)
    {
        $userEntity = new UserEntity();
        $userEntity->setFirstName($firstName);
        $userEntity->setLastName($lastName);
        $userEntity->setEmail($email);
        $userEntity->setPassword(PasswordUtil::encrypt($password));

        return $userEntity;
    }

    private function createLoginData(String $email, String $password)
    {
        return LoginData::builder()
            ->setEmail($email)
            ->setPassword($password);
    }

    private function getLoginService()
    {
        return self::$kernel->getContainer()->get('backend.service.login');
    }

    public function testLoginShouldBeSuccessful()
    {
        // given
        $this->persistDefaultUsers();
        $loginData1 = $this->createLoginData('brad.pitt@example.com', '123456');
        $loginData2 = $this->createLoginData('brad2.pitt2@example.com', '654321');

        // when
        $result1 = $this->getLoginService()->findByEmailAndPassword($loginData1);
        $result2 = $this->getLoginService()->findByEmailAndPassword($loginData2);

        // then
        $this->assertNotNull($result1);
        $this->assertNotNull($result2);
        $this->assertEquals($loginData1->getEmail(), $result1->getEmail());
        $this->assertEquals($loginData2->getEmail(), $result2->getEmail());
    }

}