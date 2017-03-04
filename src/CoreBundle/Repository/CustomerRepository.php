<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\AddressEntity;
use CoreBundle\Entity\CustomerEntity;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends SecurityRepository
{

    public function create($firstName, $lastName, $email, $password, AddressEntity $addressEntity): CustomerEntity
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setFirstName($firstName);
        $customerEntity->setLastName($lastName);
        $customerEntity->setEmail($email);
        $customerEntity->setPassword($password);
        $customerEntity->setRoles(Roles::CUSTOMER);
        $customerEntity->setAddress($addressEntity);
        return $this->persist($customerEntity);
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @return CustomerEntity|null|object
     */
    public function findCustomer($firstName, $lastName, $email)
    {
        return $this->repository()->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email
        ]);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CustomerEntity');
    }

}