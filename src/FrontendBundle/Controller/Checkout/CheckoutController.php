<?php

namespace FrontendBundle\Controller\Checkout;

use CoreBundle\Form\AddressData;
use CoreBundle\Form\PersonalData;
use CoreBundle\Model\AddressBuilder;
use CoreBundle\Model\Customer;
use CoreBundle\Model\CustomerBuilder;
use CoreBundle\Model\OrderLineBuilder;
use FrontendBundle\Controller\CategoryController;
use FrontendBundle\Model\Checkout\Step;
use FrontendBundle\Model\Checkout\StepBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class CheckoutController extends CategoryController
{

    const CHECKOUT_SESSION_KEY = 'checkout-step';

    /**
     * @Route("/checkout", name="checkout")
     */
    public function index()
    {

        $step = $this->createOrLoadStep()->getRoot();
        $this->setCurrentStep($step);
        return $step->getView();
    }

    /**
     * @Route("/checkout/previous", name="checkout_previous")
     */
    public function previous()
    {
        $step = $this->createOrLoadStep();
        if ($step->hasPrevious()) {
            $this->setCurrentStep($step->getPrevious());
        }

        return $this->createOrLoadStep()->getView();
    }

    /**
     * @Route("/checkout/next", name="checkout_next")
     */
    public function next()
    {
        $step = $this->createOrLoadStep();
        if ($step->hastNext()) {
            $this->setCurrentStep($step->getNext());
        }

        return $this->createOrLoadStep()->getView();
    }

    /**
     * @Route("/checkout/overview", name="checkout_overview")
     */
    public function overview()
    {
        $step = $this->createOrLoadStep();
        $step->getRoot()->setAttribute('shoppingCartData', $this->shoppingCartService()->getItems());
        return $this->render('@Frontend/checkout.overview.html.twig');
    }

    /**
     * @Route("/checkout/buy", name="checkout_buy")
     */
    public function buy()
    {
        $orderLines = array();
        foreach ($this->shoppingCartService()->getItems() as $item) {
            $orderLines[] = OrderLineBuilder::instance()
                ->setQuantity($item->getQuantity())
                ->setProduct($this->productService()->findById($item->getId()))
                ->build();
        }

        $customer = $this->customerService()->findOrCreate($this->getCustomer());
        $order = $this->orderService()->create($customer->getId(), $orderLines);
        $this->shoppingCartService()->removeAll();
        return $this->redirectToRoute('catalogue');
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $step = $this->createOrLoadStep();
        $parameters['currentStep'] = $step;
        return parent::render($view, $parameters, $response);
    }

    protected function createOrLoadStep(): Step
    {
        $step = null;
        if (!$this->getRequest()->getSession()->has(self::CHECKOUT_SESSION_KEY)) {
            $this->setCurrentStep(
                StepBuilder::instance('Check shopping cart', $this->redirectToRoute('checkout_shopping_cart'))
                    ->create('Personal data', $this->redirectToRoute('checkout_personal'))
                    ->create('Address', $this->redirectToRoute('checkout_address'))
                    ->create('Payment', $this->redirectToRoute('checkout_shopping_cart'))
                    ->create('Overview', $this->redirectToRoute('checkout_overview'))
                    ->build());
        }

        return $this->getRequest()->getSession()->get(self::CHECKOUT_SESSION_KEY);
    }

    protected function setCurrentStep(Step $step)
    {
        $this->getRequest()->getSession()->set(self::CHECKOUT_SESSION_KEY, $step);
    }

    private function getCustomer(): Customer
    {
        /**
         * @var PersonalData $personalData
         */
        $personalData = $this->createOrLoadStep()->getRoot()->getNext()->getAttribute(CheckoutPersonalController::PERSONAL_DATA);

        /**
         * @var AddressData $addressData
         */
        $addressData = $this->createOrLoadStep()->getRoot()->getNext()->getNext()->getAttribute(CheckoutAddressController::ADDRESS_DATA);
        $address = AddressBuilder::instance()
            ->setStreet($addressData->getStreet())
            ->setHouseNumber($addressData->getHouseNumber())
            ->setPostCode($addressData->getPostCode())
            ->setCity($addressData->getCity())
            ->build();

        return CustomerBuilder::instance()
            ->setFirstName($personalData->getFirstName())
            ->setLastName($personalData->getLastName())
            ->setEmail($personalData->getEmail())
            ->setAddress($address)
            ->build();
    }

}