<?php

namespace FrontendBundle\Controller;

use CoreBundle\Message\Message;
use CoreBundle\Service\Db\AddressMapper;
use CoreBundle\Service\Db\CustomerMapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends CategoryController
{

    /**
     * @Route("account", name="account")
     */
    public function index()
    {
        return $this->render('@Frontend/account.html.twig');
    }

    /**
     * @Route("account/my/orders", name="account_my_orders")
     */
    public function myOrders()
    {
        $orders = $this->orderService()->findByCustomerId($this->getUser()->getId());
        return $this->render('@Frontend/account.my.orders.html.twig', ['orders' => $orders]);
    }

    /**
     * @Route("account/edit/personal/data", name="account_edit_personal_data")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPersonalData()
    {
        $customer = $this->customerService()->findById($this->getUser()->getId());
        $customerData = CustomerMapper::mapToCustomerData($customer);
        return $this->renderCustomerEditForm($this->customerEditForm()->setData($customerData));
    }

    /**
     * @Route("account/submit/personal/data", name="account_submit_personal_data")
     */
    public function editPersonalDataSubmit()
    {
        $customEditForm = $this->customerEditForm()->handleRequest($this->getRequest());
        if ($customEditForm->isValid()) {
            $this->profileService()->updatePersonalData($this->getUser()->getId(), $customEditForm->getData());
            $this->addMessage(Message::success('Saved successful', 'Personal data has been saved successfully'));
        }

        return $this->renderCustomerEditForm($customEditForm);
    }

    /**
     * @Route("account/edit/address", name="account_edit_address")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAddress()
    {
        $customer = $this->customerService()->findById($this->getUser()->getId());
        $addressData = AddressMapper::mapToAddressData($customer->getAddress());
        return $this->renderEditAddressForm($this->addressEditForm()->setData($addressData));
    }

    /**
     * @Route("account/submit/address", name="account_submit_address")
     */
    public function submitAddress()
    {
        $addressEditForm = $this->addressEditForm()->handleRequest($this->getRequest());
        if ($addressEditForm->isValid()) {
            $this->profileService()->updateAddress($this->getUser()->getId(), $addressEditForm->getData());
            $this->addMessage(Message::success('Saved successful', 'Address has been saved successfully'));
        }

        return $this->renderEditAddressForm($addressEditForm);
    }

    /**
     * @Route("account/edit/password", name="account_edit_password")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPassword()
    {
        return $this->renderEditPasswordForm($this->passwordEditForm());
    }

    /**
     * @Route("account/submit/password", name="account_submit_password")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitPassword()
    {
        $passwordForm = $this->passwordEditForm()->handleRequest($this->getRequest());
        if ($passwordForm->isValid()) {
            $this->profileService()->updatePassword($this->getUser()->getId(), $passwordForm->getData());
            $this->addMessage(Message::success('Saved successful', 'Password has been saved successfully'));
        }

        return $this->renderEditPasswordForm($passwordForm);
    }

    private function renderCustomerEditForm(Form $form): Response
    {
        return $this->render('@Frontend/account.edit.personal.data.form.html.twig', ['customerForm' => $form->createView()]);
    }

    private function renderEditAddressForm(Form $form): Response
    {
        return $this->render('@Frontend/account.edit.address.form.html.twig', ['addressForm' => $form->createView()]);
    }

    private function renderEditPasswordForm(Form $form): Response
    {
        return $this->render('@Frontend/account.edit.password.form.html.twig', ['passwordForm' => $form->createView()]);
    }

}