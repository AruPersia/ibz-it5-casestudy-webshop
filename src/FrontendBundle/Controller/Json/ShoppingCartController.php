<?php

namespace FrontendBundle\Controller\Json;

use CoreBundle\Util\Json\JsonUtil;
use FrontendBundle\Controller\ServiceController;
use FrontendBundle\Service\ShoppingCart\DbItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ShoppingCartController extends ServiceController
{

    /**
     * @Route("/shopping/cart")
     * @return Response
     */
    public function itemsAction()
    {
        return JsonUtil::renderJson($this->getShoppingCartService());
    }

    /**
     * @Route("/shopping/cart/add/{productId}")
     * @param $productId
     * @return Response
     */
    public function addAction($productId)
    {
        $product = $this->entityManager()->getRepository('CoreBundle:ProductEntity')->find($productId);
        return JsonUtil::renderJson($this->getShoppingCartService()->add(new DbItem($product)));
    }

    /**
     * @Route("/shopping/cart/remove/{itemId}")
     * @param $itemId
     * @return Response
     */
    public function removeAction($itemId)
    {
        return JsonUtil::renderJson($this->getShoppingCartService()->remove($itemId));
    }

    /**
     * @Route("/shopping/cart/quantity/{itemId}/{quantity}")
     * @param $itemId
     * @param $quantity
     * @return Response
     */
    public function changeQuantityAction($itemId, $quantity)
    {
        return JsonUtil::renderJson($this->getShoppingCartService()->setQuantity($itemId, $quantity));
    }

}