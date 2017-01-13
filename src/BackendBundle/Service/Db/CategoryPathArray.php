<?php

namespace BackendBundle\Service\Db;


use CoreBundle\Entity\CategoryEntity;

class CategoryPathArray implements \Iterator
{
    private $categoryNames = array();
    private $categoryService;
    /**
     * @var CategoryEntity
     */
    private $parentCategoryEntity;
    private $index;

    public function __construct(String $categoryPath, CategoryService $categoryService)
    {
        $categoryPath = ltrim($categoryPath, '/');
        $categoryPath = rtrim($categoryPath, '/');
        $this->categoryNames = explode('/', $categoryPath);
        $this->categoryService = $categoryService;
    }

    /**
     * @return CategoryEntity
     */
    public function current()
    {
        $categoryId = null;
        if ($this->parentCategoryEntity != null) {
            $categoryId = $this->parentCategoryEntity->getId();
        }

        $categoryName = $this->categoryNames[$this->index];
        $categoryEntity = $this->categoryService->findByNameAndCategoryId($categoryName, $categoryId);

        if ($categoryEntity == null) {
            $categoryEntity = $this->categoryService->createCategory($categoryName, $this->createPath(), $this->parentCategoryEntity);
        }

        return $this->parentCategoryEntity = $categoryEntity;
    }

    private function createPath()
    {
        $fullPath = '';
        for ($i = 0; $i <= $this->index; $i++) {
            $fullPath .= $this->categoryNames[$i] . '/';
        }
        return $fullPath;
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
        return key_exists($this->index, $this->categoryNames);
    }

    public function rewind()
    {
        $this->index = 0;
        $this->parentCategoryEntity = null;

    }


}