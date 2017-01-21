<?php

namespace FrontendBundle\Controller\Json;

use CoreBundle\Util\Json\JsonUtil;
use FrontendBundle\Controller\ServiceController;
use FrontendBundle\Service\ShoppingCart\DbShoppingCartItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ShoppingCartController extends ServiceController
{

    /**
     * @Route("/shopping/cart/add/{productId}")
     * @param $productId
     * @return Response
     */
    public function addAction($productId)
    {
        $product = $this->getEntityManager()->getRepository('CoreBundle:ProductEntity')->find($productId);
        $item = $this->getShoppingCartService()->add(new DbShoppingCartItem($product));
        return JsonUtil::renderJson($item);
    }

    /**
     * @Route("/shopping/cart/increment/{itemId}")
     * @param $itemId
     * @return Response
     */
    public function incrementItem($itemId)
    {
        return JsonUtil::renderJson($this->getShoppingCartService()->incrementItem($itemId));
    }

    /**
     * @Route("/shopping/cart/decrement/{itemId}")
     * @param $itemId
     * @return Response
     */
    public function decrementItem($itemId)
    {
        return JsonUtil::renderJson($this->getShoppingCartService()->decrementItem($itemId));
    }

}