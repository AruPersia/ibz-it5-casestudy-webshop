<?php

namespace FrontendBundle\Controller\Checkout;

use CoreBundle\Form\PersonalData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;

class CheckoutPersonalController extends CheckoutController
{

    const PERSONAL_DATA = 'personalData';

    /**
     * @Route("/checkout/personal", name="checkout_personal")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $step = $this->createOrLoadStep();
        $personalForm = $this->personalForm();

        $personalData = null;
        if ($step->hasAttribute(self::PERSONAL_DATA)) {
            $data = $step->getAttribute(self::PERSONAL_DATA);
            if (!empty($data->getFirstname())) {
                $personalData = $data;
            }
        }

        if ($personalData == null && $this->getUser()) {
            $customer = $this->customerService()->findById($this->getUser()->getId());
            $personalData = PersonalData::builder()
                ->setGender($customer->getGender())
                ->setFirstName($customer->getFirstName())
                ->setLastName($customer->getLastName())
                ->setEmail($customer->getEmail());
        }

        if ($personalData != null) {
            $personalForm->setData($personalData);
        }

        return $this->renderForm($personalForm);
    }

    /**
     * @Route("/checkout/personal/verify", name="checkout_personal_verify")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verify()
    {
        $personalForm = $this->personalForm()->handleRequest($this->getRequest());
        $step = $this->createOrLoadStep()->setAttribute(self::PERSONAL_DATA, $personalForm->getData());
        $this->setCurrentStep($step);
        if ($personalForm->isValid()) {
            return $this->redirectToRoute('checkout_next');
        }

        return $this->renderForm($personalForm);
    }

    /**
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderForm(Form $form)
    {
        return $this->render('@Frontend/checkout.personal.html.twig', ['personalForm' => $form->createView()]);
    }


}