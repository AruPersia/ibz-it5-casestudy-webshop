<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Entity\UserEntity;
use BackendBundle\Form\LoginData;
use CoreBundle\Service\Db\EntityManagerService;
use CoreBundle\Util\PasswordUtil;

class LoginService extends EntityManagerService
{

    /**
     * @param LoginData $loginData
     * @return null|UserEntity
     */
    public function findByEmailAndPassword(LoginData $loginData)
    {
        return $this->getUserRepository()->findOneBy(['email' => $loginData->getEmail(), 'password' => PasswordUtil::encrypt($loginData->getPassword())]);
    }

    private function getUserRepository()
    {
        return $this->em->getRepository('BackendBundle:UserEntity');
    }
}