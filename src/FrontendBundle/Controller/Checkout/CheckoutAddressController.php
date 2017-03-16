<?php

namespace FrontendBundle\Controller\Checkout;

use FrontendBundle\Form\AddressData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;

class CheckoutAddressController extends CheckoutController
{

    const ADDRESS_DATA = 'addressData';

    /**
     * @Route("/checkout/address", name="checkout_address")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $step = $this->createOrLoadStep();
        $addressForm = $this->addressForm();

        $addressData = null;
        if ($step->hasAttribute(self::ADDRESS_DATA)) {
            $data = $step->getAttribute(self::ADDRESS_DATA);
            if (!empty($data->getStreet())) {
                $addressData = $data;
            }
        }

        if ($addressData == null && $this->getUser()) {
            $customer = $this->customerService()->findById($this->getUser()->getId());
            $address = $customer->getAddress();
            $addressData = AddressData::builder()
                ->setStreet($address->getStreet())
                ->setHouseNumber($address->getHouseNumber())
                ->setPostCode($address->getPostCode())
                ->setCity($address->getCity());
        }

        if ($addressData != null) {
            $addressForm->setData($addressData);
        }

        return $this->renderAddressForm($addressForm);
    }

    /**
     * @Route("/checkout/address/verify", name="checkout_address_verify")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verify()
    {
        $addressForm = $this->addressForm()->handleRequest($this->getRequest());
        $step = $this->createOrLoadStep()->setAttribute(self::ADDRESS_DATA, $addressForm->getData());
        $this->setCurrentStep($step);
        if ($addressForm->isValid()) {
            return $this->redirectToRoute('checkout_next');
        }

        return $this->renderAddressForm($addressForm);
    }

    /**
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderAddressForm(Form $form)
    {
        return $this->render('@Frontend/checkout.address.html.twig', ['addressForm' => $form->createView()]);
    }


}