<?php

namespace CoreBundle\Model;

class Categories implements \Iterator
{
    private $items;
    private $index = 0;

    public function __construct()
    {
        $this->items = array();
    }

    public function add(Category $category)
    {
        $this->items[] = $category;
    }

    public function current(): Category
    {
        return $this->items[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return array_key_exists($this->index, $this->items);
    }

    public function rewind()
    {
        $this->index = 0;
    }

}