<?php
namespace FrontendBundle\Service\Db;

use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Service\Db\EntityManagerService;
use CoreBundle\Util\PasswordUtil;
use FrontendBundle\Form\RegistrationFormData;

class RegistrationService extends EntityManagerService
{

    /**
     * @param RegistrationFormData $registrationFormData
     * @return CustomerEntity
     */
    public function register(RegistrationFormData $registrationFormData)
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setFirstName($registrationFormData->getFirstName());
        $customerEntity->setLastName($registrationFormData->getLastName());
        $customerEntity->setEmail($registrationFormData->getEmail());
        $customerEntity->setPassword(PasswordUtil::encrypt($registrationFormData->getPassword()));
        $customerEntity->setRoles('CUSTOMER');
        $this->save($customerEntity);

        return $customerEntity;
    }

    public function save(CustomerEntity $customerEntity)
    {
        $this->em->persist($customerEntity);
        $this->em->flush();
    }

    public function update(CustomerEntity $customerEntity)
    {
        $this->em->merge($customerEntity);
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
        return $this->em->getRepository('CoreBundle:CustomerEntity');
    }

    public function delete(Int $customerId)
    {
        $customerRef = $this->em->getReference('AppBundle:CustomerEntity', $customerId);
        $this->em->remove($customerRef);
        $this->em->flush();
    }

}