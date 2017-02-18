<?php

namespace CoreBundle\Model;

class CategoryBuilder implements Builder
{
    private $id;
    private $path;

    /**
     * @var CategoryBuilder
     */
    private $parent;

    /**
     * @var CategoryBuilder[]
     */
    private $children = array();

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
        return $this->getRootCategory()->doBuild();
    }

    public function setId($id): CategoryBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setPath($path): CategoryBuilder
    {
        $this->path = $path;
        return $this;
    }

    public function setParent(CategoryBuilder $builder): CategoryBuilder
    {
        $this->parent = $builder;
        $builder->children[] = $this;
        return $this;
    }

    public function addChild(CategoryBuilder $categoryBuilder): CategoryBuilder
    {
        $categoryBuilder->setPath($this->path . Category::DELIMITER . $categoryBuilder->path);
        $this->children[] = $categoryBuilder;
        return $this;
    }

    public function createNode(String $path): CategoryBuilder
    {
        return CategoryBuilder::instance()
            ->setPath($this->path . Category::DELIMITER . $path)
            ->setParent($this);
    }

    private function doBuild(Category $parent = null): Category
    {
        $category = new Category($this->id, $this->path, $parent);
        foreach ($this->children as $child) {
            $child->doBuild($category);
        }

        return $category;
    }

    private function getRootCategory()
    {
        $rootCategory = $this;
        while ($rootCategory->parent != null) {
            $rootCategory = $rootCategory->parent;
        }

        return $rootCategory;
    }


}