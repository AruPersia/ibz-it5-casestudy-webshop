<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserAuthenticationRepository")
 */
class CustomerEntity extends UserAuthentication
{

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;


    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return (String)sprintf("Customer(%s)",
            implode(", ", [
                $this->getId(),
                $this->firstName,
                $this->lastName,
                $this->getEmail()])
        );
    }

}