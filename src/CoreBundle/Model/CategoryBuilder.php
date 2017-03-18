<?php

namespace CoreBundle\Model;

class CategoryBuilder implements Builder
{

    private $id;
    private $path;

    private function __construct()
    {
        // private constructor
    }

    public static function instance(): CategoryBuilder
    {
        return new CategoryBuilder();
    }

    public function build(): Category
    {
        return new Category($this->id, $this->path);
    }

    public function setId($id): CategoryBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setPath(Path $path): CategoryBuilder
    {
        $this->path = $path;
        return $this;
    }

}