<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\AddressEntity;
use Doctrine\ORM\EntityRepository;

class AddressRepository extends AbstractRepository
{

    /**
     * @param $street
     * @param $houseNumber
     * @param $postcode
     * @param $city
     * @return AddressEntity
     */
    public function create($street, $houseNumber, $postcode, $city): AddressEntity
    {
        $addressEntity = $this->find($street, $houseNumber, $postcode, $city);
        if ($addressEntity != null) {
            return $addressEntity;
        }

        return $this->doCreate($street, $houseNumber, $postcode, $city);
    }

    /**
     * @param $street
     * @param $houseNumber
     * @param $postcode
     * @param $city
     * @return AddressEntity|null
     */
    public function find($street, $houseNumber, $postcode, $city)
    {
        return $this->findByAddressEntity($this->neutralizeData($street, $houseNumber, $postcode, $city));
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:AddressEntity');
    }

    private function doCreate($street, $houseNumber, $postcode, $city): AddressEntity
    {
        return $this->persist($this->neutralizeData($street, $houseNumber, $postcode, $city));
    }

    private function findByAddressEntity(AddressEntity $addressEntity)
    {
        return $this->repository()->findOneBy([
            'street' => $addressEntity->getStreet(),
            'houseNumber' => $addressEntity->getHouseNumber(),
            'postcode' => $addressEntity->getPostcode(),
            'city' => $addressEntity->getCity(),
        ]);
    }

    private function neutralizeData($street, $houseNumber, $postcode, $city): AddressEntity
    {
        $street = ucfirst(mb_strtolower($street));
        $houseNumber = mb_strtolower($houseNumber);
        $city = ucfirst(mb_strtolower($city));
        return AddressEntity::instance()
            ->setStreet($street)
            ->setHouseNumber($houseNumber)
            ->setPostcode($postcode)
            ->setCity($city);
    }

}