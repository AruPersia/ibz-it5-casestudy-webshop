<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Category
{
    const DELIMITER = '/';

    private $id;
    private $name;
    private $path;
    private $parent;
    private $children = array();

    public function __construct($id, $path, Category $parent = null)
    {
        $path = self::removeSlashes($path);
        ValidateUtil::notNull($path);
        ValidateUtil::notEmpty($path);

        $this->id = $id;
        $this->name = $this->extractName($path);
        $this->path = $path;
        $this->parent = $parent;
        if ($parent != null) {
            $parent->children[] = $this;
        }
    }

    public static function removeSlashes($path): String
    {
        return ltrim(rtrim($path, self::DELIMITER), self::DELIMITER);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function hasParent()
    {
        return $this->parent != null;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return !empty($this->children);
    }

    private function extractName($path): String
    {
        $strings = explode(self::DELIMITER, $path);
        return end($strings);
    }

}