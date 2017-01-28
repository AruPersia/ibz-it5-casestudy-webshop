<?php

namespace FrontendBundle\Service\ShoppingCart;

use CoreBundle\Util\Json\JsonData;

class ItemChanged implements JsonData
{

    private $shoppingCartService;
    private $changedItem;

    public function __construct(ShoppingCartService $shoppingCartService, Item $changedItem)
    {
        $this->shoppingCartService = $shoppingCartService;
        $this->changedItem = $changedItem;
    }

    public function getJsonData()
    {
        $jsonData = $this->shoppingCartService->getJsonData();
        $jsonData['itemChanged'] = $this->changedItem->getJsonData();
        return $jsonData;
    }


}