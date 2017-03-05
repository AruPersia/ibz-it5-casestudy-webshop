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

    public function update($customerId, $firstName, $lastName, $email): CustomerEntity
    {
        return $this->merge($this->findById($customerId)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email));
    }

    public function updateAddress($customerId, AddressEntity $addressEntity): CustomerEntity
    {
        return $this->merge($this->findById($customerId)->setAddress($addressEntity));
    }

    public function updatePassword($customerId, $password): CustomerEntity
    {
        return $this->merge($this->findById($customerId)->setPassword($password));
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

    /**
     * @param $id
     * @return CustomerEntity|null|object
     */
    public function findById($id)
    {
        return $this->repository()->find($id);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CustomerEntity');
    }

}