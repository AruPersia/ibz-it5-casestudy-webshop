<?php

namespace FrontendBundle\Service\ShoppingCart;

use CoreBundle\Util\Json\JsonData;

interface Item extends JsonData
{

    public function getId();

    public function getName();

    public function getPrice();

    public function getImage();

    public function getQuantity();

    public function setQuantity($quantity);

    public function getSum();

}