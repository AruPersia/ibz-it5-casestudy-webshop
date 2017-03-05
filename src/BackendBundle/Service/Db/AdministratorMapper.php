<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Entity\AdministratorEntity;
use CoreBundle\Model\Administrator;

class AdministratorMapper
{

    public static function mapToAdministrator(AdministratorEntity $administratorEntity): Administrator
    {
        return new Administrator(
            $administratorEntity->getId(),
            $administratorEntity->getFirstName(),
            $administratorEntity->getLastName(),
            $administratorEntity->getEmail(),
            $administratorEntity->getRoles());
    }

}