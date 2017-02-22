<?php

namespace CoreBundle\Model;


class PathBuilder
{

    private $path;
    private $parent;

    private function __construct()
    {
        // keep private
    }

    public static function createByPath($path): Path
    {
        $path = ltrim($path, Path::DELIMITER);
        $path = rtrim($path, Path::DELIMITER);
        $names = explode(Path::DELIMITER, $path);
        $firstElementName = array_shift($names);
        $builder = PathBuilder::create($firstElementName);

        foreach ($names as $name) {
            $builder = $builder->createChild($name);
        }

        return $builder->build();
    }

    public static function create($name): PathBuilder
    {
        return (new PathBuilder())->setPath(Path::DELIMITER)->createChild($name);
    }

    public function createChild($name): PathBuilder
    {
        return (new PathBuilder())->setPath($this->concatenateWithPath($name))->setParent($this);
    }

    public function setPath($path): PathBuilder
    {
        $this->path = $path;
        return $this;
    }

    public function setParent(PathBuilder $parent): PathBuilder
    {
        $this->parent = $parent;
        return $this;
    }

    public function build(): Path
    {
        return $this->doBuild($this);
    }

    /**
     * @param PathBuilder|null $builder
     * @return Path|null
     */
    private function doBuild(PathBuilder $builder = null)
    {
        if ($builder == null) {
            return null;
        }

        return new Path($builder->path, $this->doBuild($builder->parent));
    }

    private function concatenateWithPath($name): String
    {
        if ($this->path == Path::DELIMITER) {
            return $this->path . $name;
        }

        return $this->path . Path::DELIMITER . $name;
    }

}