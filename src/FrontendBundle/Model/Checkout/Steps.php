<?php

namespace FrontendBundle\Model\Checkout;

class Steps implements \Iterator
{

    private $key;
    private $steps;

    private function __construct($steps = array())
    {
        $this->steps = $steps;
    }

    public static function create(Step... $steps)
    {
        return new Steps($steps);
    }

    public function current(): Step
    {
        return $this->steps[$this->key];
    }

    public function next()
    {
        $this->key++;
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return array_key_exists($this->key, $this->steps);
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function size()
    {
        return count($this->steps);
    }

    public function get($key): Step
    {
        return $this->steps[$key];
    }

}