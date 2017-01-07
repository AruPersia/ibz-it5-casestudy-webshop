<?php

namespace AdminBundle\Service;

use AdminBundle\Entity\UserEntity;
use AdminBundle\Form\LoginData;

class LoginService extends DbService
{

    /**
     * @param LoginData $loginData
     * @return null|UserEntity
     */
    public function findByEmailAndPassword(LoginData $loginData)
    {
        return $this->getAdminRepository()->findOneBy(['email' => $loginData->getEmail(), 'password' => $loginData->getPassword()]);
    }

    private function getAdminRepository()
    {
        return $this->em->getRepository('AdminBundle:UserEntity');
    }
}