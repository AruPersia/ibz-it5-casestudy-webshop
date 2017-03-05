<?php

namespace CoreBundle\Repository;

use BackendBundle\Entity\AdministratorEntity;
use Doctrine\ORM\EntityRepository;

class AdministratorRepository extends SecurityRepository
{

    public function create($firstName, $lastName, $email, $password): AdministratorEntity
    {
        $administratorEntity = new AdministratorEntity();
        $administratorEntity->setFirstName($firstName);
        $administratorEntity->setLastName($lastName);
        $administratorEntity->setEmail($email);
        $administratorEntity->setPassword($password);
        $administratorEntity->setRoles(Roles::ADMIN);
        return $this->persist($administratorEntity);
    }

    public function update($administratorId, $firstName, $lastName, $email): AdministratorEntity
    {
        return $this->merge($this->findById($administratorId)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email));
    }

    public function updatePassword($administratorId, $password): AdministratorEntity
    {
        return $this->merge($this->findById($administratorId)->setPassword($password));
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('BackendBundle:AdministratorEntity');
    }

    /**
     * @param $administratorId
     * @return AdministratorEntity|null|object
     */
    private function findById($administratorId)
    {
        return $this->repository()->find($administratorId);
    }

}