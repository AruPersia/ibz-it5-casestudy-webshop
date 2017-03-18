<?php

namespace FrontendBundle\Model\Checkout;

class Checkout
{

    private $steps;
    private $current = 0;

    public function __construct(Steps $steps)
    {
        $this->steps = $steps;
    }

    public function steps(): Steps
    {
        return $this->steps;
    }

    public function current(): Step
    {
        return $this->steps->get($this->current);
    }

}