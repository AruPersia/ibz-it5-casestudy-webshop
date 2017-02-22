<?php

namespace CoreBundle\Model;

class Category
{

    private $id;
    private $path;

    public function __construct($id, Path $path)
    {
        $this->id = $id;
        $this->path = $path;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPath(): Path
    {
        return $this->path;
    }

}