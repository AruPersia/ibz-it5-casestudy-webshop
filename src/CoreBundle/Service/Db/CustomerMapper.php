<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arash
 * Date: 23.02.2017
 * Time: 00:07
 */

namespace CoreBundle\Service\Db;


use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Model\Customer;
use CoreBundle\Model\CustomerBuilder;

class CustomerMapper
{

    public static function mapToCustomer(CustomerEntity $customerEntity): Customer
    {
        return CustomerBuilder::instance()
            ->setId($customerEntity->getId())
            ->setFirstName($customerEntity->getFirstName())
            ->setLastName($customerEntity->getLastName())
            ->setEmail($customerEntity->getEmail())
            ->setAddress(AddressMapper::mapToAddress($customerEntity->getAddress()))
            ->build();
    }

}