<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\AddressEntity;
use CoreBundle\Model\Address;
use CoreBundle\Model\AddressBuilder;

class AddressMapper
{

    public static function mapToAddress(AddressEntity $addressEntity): Address
    {
        return AddressBuilder::instance()
            ->setId($addressEntity->getId())
            ->setStreet($addressEntity->getStreet())
            ->setHouseNumber($addressEntity->getHouseNumber())
            ->setPostCode($addressEntity->getPostcode())
            ->setCity($addressEntity->getCity())
            ->build();
    }

}