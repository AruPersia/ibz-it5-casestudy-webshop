<?php

namespace FrontendBundle\Service\ShoppingCart;

use CoreBundle\Util\Json\JsonData;

interface ShoppingCartService extends JsonData
{
    public function add(Item $item): Item;

    public function remove($itemId): Item;

    public function setQuantity($itemId, $quantity): Item;

    /**
     * @param $itemId
     * @return Item|null
     */
    public function getItem($itemId);

    /**
     * @return Item[]
     */
    public function getItems();

    public function hasItems();

    public function getSum();
}