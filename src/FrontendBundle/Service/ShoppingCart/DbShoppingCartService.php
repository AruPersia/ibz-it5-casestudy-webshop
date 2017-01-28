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
     * @return Item[]
     */
    private function loadShoppingCart()
    {
        if ($this->request->getSession()->has(self::SESSION_KEY)) {
            return $this->request->getSession()->get(self::SESSION_KEY);
        }

        return array();
    }

    public function setQuantity($itemId, $quantity): Item
    {
        if ($item = $this->getItem($itemId)) {
            $item->setQuantity($quantity);
            $this->flushSession();
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

    private function flushSession()
    {
        $this->request->getSession()->set(self::SESSION_KEY, $this->shoppingCartItems);
    }

    public function add(Item $item): Item
    {
        if ($availableItem = $this->getItem($item->getId())) {
            $availableItem->setQuantity($availableItem->getQuantity() + 1);
            $item = $availableItem;
        } else {
            $this->shoppingCartItems[$item->getId()] = $item;
        }

        $this->flushSession();
        return $item;
    }

    public function hasItems()
    {
        return count($this->shoppingCartItems) > 0;
    }

    public function remove($itemId): Item
    {
        $itemToDelete = $this->getItem($itemId);
        unset($this->shoppingCartItems[$itemId]);
        $this->flushSession();
        return $itemToDelete;
    }

    public function getJsonData()
    {
        $jsonData = array();
        foreach ($this->getItems() as $item) {
            $jsonData['items'][] = $item->getJsonData();
        }
        $jsonData['sum'] = $this->getSum();

        return $jsonData;
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

    private function changeQuantity($itemId, $quantity): ItemChanged
    {
        if ($item = $this->getItem($itemId)) {
            $item->setQuantity($item->getQuantity() + $quantity);
        }

        return new ItemChanged($this, $item);
    }


}