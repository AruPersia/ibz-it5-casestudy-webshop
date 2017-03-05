<?php

namespace FrontendBundle\Controller;

use CoreBundle\Service\Db\AddressMapper;
use CoreBundle\Service\Db\CustomerMapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends CategoryController
{

    /**
     * @Route("profile", name="profile")
     */
    public function index()
    {
        return $this->render('@Frontend/profile.html.twig');
    }

    /**
     * @Route("profile/edit/personal/data", name="profile_edit_personal_data")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPersonalData()
    {
        $customer = $this->customerService()->findById($this->getUser()->getId());
        $customerData = CustomerMapper::mapToCustomerData($customer);
        return $this->renderCustomerEditForm($this->customerEditForm()->setData($customerData));
    }

    /**
     * @Route("profile/edit/personal/data/submit", name="profile_edit_personal_data_submit")
     */
    public function editPersonalDataSubmit()
    {
        $customEditForm = $this->customerEditForm()->handleRequest($this->getRequest());
        if (!$customEditForm->isValid()) {
            return $this->renderCustomerEditForm($customEditForm);
        }

        // FIXME AAF: Forward here would be a better choice
        $this->profileService()->updatePersonalData($this->getUser()->getId(), $customEditForm->getData());
        return $this->renderCustomerEditForm($customEditForm);
    }

    /**
     * @Route("profile/edit/address", name="profile_edit_address")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAddress()
    {
        $customer = $this->customerService()->findById($this->getUser()->getId());
        $addressData = AddressMapper::mapToAddressData($customer->getAddress());
        return $this->renderEditAddressForm($this->addressEditForm()->setData($addressData));
    }

    /**
     * @Route("profile/edit/address/submit", name="profile_edit_address_submit")
     */
    public function editAddressSubmit()
    {
        $addressEditForm = $this->addressEditForm()->handleRequest($this->getRequest());
        if (!$addressEditForm->isValid()) {
            return $this->renderCustomerEditForm($addressEditForm);
        }

        // FIXME AAF: Forward here would be a better choice
        $this->profileService()->updateAddress($this->getUser()->getId(), $addressEditForm->getData());
        return $this->renderEditAddressForm($addressEditForm);
    }

    private function renderCustomerEditForm(Form $form): Response
    {
        return $this->render('@Frontend/profile.edit.personal.data.form.html.twig', ['customerForm' => $form->createView()]);
    }

    private function renderEditAddressForm(Form $form): Response
    {
        return $this->render('@Frontend/profile.edit.address.form.html.twig', ['addressForm' => $form->createView()]);
    }

}