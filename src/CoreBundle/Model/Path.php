<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Path
{

    const DELIMITER = '/';

    private $path;
    private $name;
    private $parent;

    public function __construct($path, Path $parent = null)
    {
        $this->path = ValidateUtil::notEmpty($path);
        $this->name = substr($path, strrpos($path, self::DELIMITER) + 1);
        $this->parent = $parent;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Path|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    function __toString()
    {
        return $this->path;
    }


}