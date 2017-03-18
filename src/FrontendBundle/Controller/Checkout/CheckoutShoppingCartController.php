<?php

namespace FrontendBundle\Controller\Checkout;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CheckoutShoppingCartController extends CheckoutController
{

    /**
     * @Route("/checkout/shoppingCart", name="checkout_shopping_cart")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('@Frontend/checkout.shopping.cart.html.twig');
    }

}