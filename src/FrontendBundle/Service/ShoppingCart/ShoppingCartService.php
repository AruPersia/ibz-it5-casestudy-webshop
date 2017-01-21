<?php

namespace FrontendBundle\Service\ShoppingCart;

interface ShoppingCartService
{
    public function incrementItem($itemId): ShoppingCartItem;

    public function decrementItem($itemId): ShoppingCartItem;

    public function add(ShoppingCartItem $item): ShoppingCartItem;

    public function remove(ShoppingCartItem $item);

    /**
     * @param $itemId
     * @return ShoppingCartItem|null
     */
    public function getItem($itemId);

    /**
     * @return ShoppingCartItem[]
     */
    public function getItems();

    public function hasItems();

    public function getSum();
}