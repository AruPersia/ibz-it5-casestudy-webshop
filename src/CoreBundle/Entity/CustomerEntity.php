<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class CustomerEntity extends SecurityEntity
{

    /**
     * @ORM\Column(name="firstName", type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\OrderEntity", mappedBy="customer", fetch="EAGER")
     */
    private $orders;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

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

    public function getOrders()
    {
        return $this->orders;
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