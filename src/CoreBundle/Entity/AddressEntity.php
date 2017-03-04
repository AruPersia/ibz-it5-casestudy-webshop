<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class AddressEntity implements EntityBuilder
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="street", type="string", length=50)
     */
    private $street;

    /**
     * @ORM\Column(name="houseNumber", type="string", length=50)
     */
    private $houseNumber;

    /**
     * @ORM\Column(name="postcode", type="integer")
     */
    private $postcode;

    /**
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    public static function instance()
    {
        return new AddressEntity();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): AddressEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street): AddressEntity
    {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    public function setHouseNumber($houseNumber): AddressEntity
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode): AddressEntity
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): AddressEntity
    {
        $this->city = $city;
        return $this;
    }

}