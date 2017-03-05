<?php

namespace FrontendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationData
{

    /**
     * @Assert\Valid()
     */
    private $customerData;

    /**
     * @Assert\Valid()
     */
    private $passwordData;

    /**
     * @Assert\Valid()
     */
    private $addressData;

    public static function builder()
    {
        return new RegistrationData();
    }

    /**
     * @return CustomerData|null
     */
    public function getCustomerData()
    {
        return $this->customerData;
    }

    public function setCustomerData(CustomerData $customerData): RegistrationData
    {
        $this->customerData = $customerData;
        return $this;
    }

    /**
     * @return PasswordData|null
     */
    public function getPasswordData()
    {
        return $this->passwordData;
    }

    public function setPasswordData(PasswordData $passwordData): RegistrationData
    {
        $this->passwordData = $passwordData;
        return $this;
    }

    /**
     * @return AddressData|null
     */
    public function getAddressData()
    {
        return $this->addressData;
    }

    public function setAddressData(AddressData $addressData = null): RegistrationData
    {
        $this->addressData = $addressData;
        return $this;
    }

}