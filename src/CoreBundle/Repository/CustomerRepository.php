<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CustomerEntity;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends SecurityRepository
{

    public function create($firstName, $lastName, $email, $password): CustomerEntity
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setFirstName($firstName);
        $customerEntity->setLastName($lastName);
        $customerEntity->setEmail($email);
        $customerEntity->setPassword($password);
        $customerEntity->setRoles(Roles::CUSTOMER);
        return $this->persist($customerEntity);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CustomerEntity');
    }

}