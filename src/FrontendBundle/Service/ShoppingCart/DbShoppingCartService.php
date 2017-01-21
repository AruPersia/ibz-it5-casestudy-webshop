<?php

namespace FrontendBundle\Service\ShoppingCart;

use Symfony\Component\HttpFoundation\RequestStack;

class DbShoppingCartService implements ShoppingCartService
{

    const SESSION_KEY = 'SHOPPING_CART';

    private $request;
    private $shoppingCartItems;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->shoppingCartItems = $this->loadShoppingCart();
    }

    /**
     * @return ShoppingCartItem[]
     */
    private function loadShoppingCart()
    {
        if ($this->request->getSession()->has(self::SESSION_KEY)) {
            return $this->request->getSession()->get(self::SESSION_KEY);
        }

        return array();
    }

    public function incrementItem($itemId): ShoppingCartItem
    {
        return $this->changeQuantity($itemId, 1);
    }

    private function changeQuantity($itemId, $quantity): ShoppingCartItem
    {
        if ($item = $this->getItem($itemId)) {
            $item->setQuantity($item->getQuantity() + $quantity);
        }

        return $item;
    }

    public function getItem($itemId)
    {
        if (array_key_exists($itemId, $this->shoppingCartItems)) {
            return $this->shoppingCartItems[$itemId];
        }

        return null;
    }

    public function decrementItem($itemId): ShoppingCartItem
    {
        return $this->changeQuantity($itemId, -1);
    }

    public function add(ShoppingCartItem $item): ShoppingCartItem
    {
        if ($availableItem = $this->getItem($item->getId())) {
            $availableItem->setQuantity($availableItem->getQuantity() + 1);
            $item = $availableItem;
        } else {
            $this->shoppingCartItems[$item->getId()] = $item;
        }

        $this->updateShoppingCartSession();
        return $item;
    }

    private function updateShoppingCartSession()
    {
        $this->request->getSession()->set(self::SESSION_KEY, $this->shoppingCartItems);
    }


    public function hasItems()
    {
        return count($this->shoppingCartItems) > 0;
    }

    public function remove(ShoppingCartItem $item)
    {
        unset($this->shoppingCartItems[$item->getId()]);
        $this->updateShoppingCartSession();
    }

    public function getItems()
    {
        return $this->shoppingCartItems;
    }

    public function getSum()
    {
        $total = 0;
        foreach ($this->shoppingCartItems as $item) {
            $total += $item->getSum();
        }

        return $total;
    }


}