<?php

namespace FrontendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationData
{

    /**
     * @Assert\Valid()
     */
    private $customerWithPwData;

    /**
     * @Assert\Valid()
     */
    private $addressData;

    public static function builder()
    {
        return new RegistrationData();
    }

    /**
     * @return CustomerWithPwData|null
     */
    public function getCustomerWithPwData()
    {
        return $this->customerWithPwData;
    }

    public function setCustomerWithPwData(CustomerWithPwData $customerWithPwData): RegistrationData
    {
        $this->customerWithPwData = $customerWithPwData;
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