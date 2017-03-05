<?php

namespace BackendBundle\Entity;

use CoreBundle\Entity\SecurityEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="administrator")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\SecurityRepository")
 */
class AdministratorEntity extends SecurityEntity
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    public static function instance(): AdministratorEntity
    {
        return new AdministratorEntity();
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
}