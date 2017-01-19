<?php

namespace CoreBundle\Service\Security;

use CoreBundle\Entity\SecurityEntity;
use CoreBundle\Form\LoginData;

interface SecurityRepositorySupport
{

    /**
     * @param LoginData $loginData
     * @return SecurityEntity
     */
    public function loadUserByEmailAndPassword(LoginData $loginData);

}