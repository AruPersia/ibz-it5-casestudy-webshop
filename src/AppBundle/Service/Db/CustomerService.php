<?php
namespace AppBundle\Service\Db;

use AppBundle\Entity\CustomerEntity;
use AppBundle\Util\PasswordUtil;

/**
 * User: Arash
 * Date: 31.12.2016
 * Time: 12:27
 */
class CustomerService extends DbBaseService
{

    public function save(CustomerEntity $customer)
    {
        $this->em->persist($customer);
        $this->em->flush();
    }

    public function update(CustomerEntity $customer)
    {
        $this->em->merge($customer);
        $this->em->flush();
    }

    /**
     * @param String $email
     * @param String $password
     * @return null|CustomerEntity
     */
    public function findByEmailAndPassword(String $email, String $password)
    {
        return $this->getRepository()->findOneBy([
            'email' => $email,
            'password' => PasswordUtil::encrypt($password)
        ]);
    }

    private function getRepository()
    {
        return $this->em->getRepository('AppBundle:CustomerEntity');
    }

    public function delete(Int $customerId)
    {
        $customerRef = $this->em->getReference('AppBundle:CustomerEntity', $customerId);
        $this->em->remove($customerRef);
        $this->em->flush();
    }

}