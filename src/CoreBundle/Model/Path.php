<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Path
{
    const DELIMITER = '/';

    private $name;
    private $path;

    private function __construct($name, $path)
    {
        ValidateUtil::notNulls($name, $path);
        $this->name = $name;
        $this->path = $path;
    }

    public static function create($path): Path
    {
        $path = self::removeSlashes($path);
        return new Path($path, self::extractName($path));
    }

    private static function removeSlashes($path): String
    {
        return ltrim(rtrim($path, self::DELIMITER), self::DELIMITER);
    }

    private static function extractName($path): String
    {
        $strings = explode(self::DELIMITER, $path);
        return end($strings);
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

}