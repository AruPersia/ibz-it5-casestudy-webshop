<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arash
 * Date: 23.02.2017
 * Time: 00:07
 */

namespace CoreBundle\Service\Db;


use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Model\Customer;
use CoreBundle\Model\CustomerBuilder;
use FrontendBundle\Form\CustomerData;

class CustomerMapper
{

    public static function mapToCustomer(CustomerEntity $customerEntity): Customer
    {
        return CustomerBuilder::instance()
            ->setId($customerEntity->getId())
            ->setFirstName($customerEntity->getFirstName())
            ->setLastName($customerEntity->getLastName())
            ->setEmail($customerEntity->getEmail())
            ->setAddress(AddressMapper::mapToAddress($customerEntity->getAddress()))
            ->build();
    }

    /**
     * @param CustomerEntity[] $customerEntities
     * @return Customer[]
     */
    public static function mapToCustomers($customerEntities)
    {
        $customers = array();
        foreach ($customerEntities as $customerEntity) {
            $customers[] = self::mapToCustomer($customerEntity);
        }
        return $customers;
    }

    public static function mapToCustomerData(Customer $customer): CustomerData
    {
        return CustomerData::builder()
            ->setFirstName($customer->getFirstName())
            ->setLastName($customer->getLastName())
            ->setEmail($customer->getEmail());
    }

}