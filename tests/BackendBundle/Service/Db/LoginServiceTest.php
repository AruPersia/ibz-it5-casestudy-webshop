<?php

namespace Tests\BackendBundle\Service\Db;

use BackendBundle\Form\AdministratorData;
use CoreBundle\Form\LoginData;
use CoreBundle\Form\PasswordData;
use CoreBundle\Util\PasswordUtil;
use Tests\CoreBundle\Boot\TestWithDb;

class LoginServiceTest extends TestWithDb
{

    public function testLoginShouldNotBeSuccessful()
    {
        // given
        $this->persistDefaultUsers();
        $loginData = LoginData::builder()->setEmail('emma.stone@localhost.local')->setPassword('123');

        // when
        $this->backendSecurityService()->login($loginData);
    }

    private function persistDefaultUsers()
    {
        $administrators = array();
        $passwordData = PasswordData::builder()->setPassword(PasswordUtil::encrypt('123'));
        $administrators[] = $this->createAdministratorData('Emma', 'Stone', $passwordData);
        $administrators[] = $this->createAdministratorData('Jennifer', 'Aniston', $passwordData);
        $administrators[] = $this->createAdministratorData('Angelina', 'Jolie', $passwordData);
        foreach ($administrators as $administrator) {
            $this->administratorService()->create($administrator);
        }
    }

    private function createAdministratorData($firstName, $lastName, PasswordData $passwordData): AdministratorData
    {
        return AdministratorData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(mb_strtolower($firstName . '.' . $lastName . '@localhost.local'))
            ->setPasswordData($passwordData);
    }

}