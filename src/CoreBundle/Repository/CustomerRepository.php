<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\AddressEntity;
use CoreBundle\Entity\CustomerEntity;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends SecurityRepository
{

    public function create($gender, $firstName, $lastName, $email, $password, AddressEntity $addressEntity): CustomerEntity
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setGender($gender);
        $customerEntity->setFirstName($firstName);
        $customerEntity->setLastName($lastName);
        $customerEntity->setEmail($email);
        $customerEntity->setPassword($password);
        $customerEntity->setRoles(Roles::CUSTOMER);
        $customerEntity->setAddress($addressEntity);
        return $this->persist($customerEntity);
    }

    public function update($customerId, $gender, $firstName, $lastName, $email): CustomerEntity
    {
        return $this->merge($this->findById($customerId)
            ->setGender($gender)
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

    /**
     * @return CustomerEntity[]
     */
    public function findAll()
    {
        return $this->repository()->findAll();
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CustomerEntity');
    }

}