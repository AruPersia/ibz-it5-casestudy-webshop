<?php

namespace BackendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ReorderData
{

    /**
     * @Assert\NotBlank()
     */
    private $productId;

    /**
     * @Assert\NotBlank()
     */
    private $quantity;

    /**
     * @Assert\Date()
     */
    private $reorderDate;

    /**
     * @Assert\Date()
     */
    private $expectedDate;

    public static function instance(): ReorderData
    {
        return new ReorderData();
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId): ReorderData
    {
        $this->productId = $productId;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): ReorderData
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getReorderDate()
    {
        return $this->reorderDate;
    }

    public function setReorderDate($reorderDate): ReorderData
    {
        $this->reorderDate = $reorderDate;
        return $this;
    }

    public function getExpectedDate()
    {
        return $this->expectedDate;
    }

    public function setExpectedDate($expectedDate): ReorderData
    {
        $this->expectedDate = $expectedDate;
        return $this;
    }

}

