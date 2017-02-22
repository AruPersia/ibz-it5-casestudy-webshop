<?php

namespace CoreBundle\Model;

class OrderLineBuilder
{

    private $id;
    private $product;
    private $quantity;
    private $price;

    private function __construct()
    {
        // Keep private
        $this->orderLines = array();
    }

    public static function instance(): OrderLineBuilder
    {
        return new OrderLineBuilder();
    }

    public function setId($id): OrderLineBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setProduct($product): OrderLineBuilder
    {
        $this->product = $product;
        return $this;
    }

    public function setQuantity($quantity): OrderLineBuilder
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setPrice($price): OrderLineBuilder
    {
        $this->price = $price;
        return $this;
    }

    public function build(): OrderLine
    {
        return new OrderLine($this->id, $this->product, $this->quantity, $this->price);
    }

}