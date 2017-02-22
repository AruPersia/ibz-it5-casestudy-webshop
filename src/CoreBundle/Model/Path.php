<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Path
{

    const DELIMITER = '/';

    private $path;
    private $parent;

    public function __construct($path, Path $parent = null)
    {
        $this->path = ValidateUtil::notEmpty($path);
        $this->parent = $parent;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return Path
     */
    public function getParent()
    {
        return $this->parent;
    }

}