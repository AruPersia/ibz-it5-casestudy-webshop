<?php

namespace BackendBundle\Service\Db;


class CategoryPathExtractorService
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param String $categoryPath
     * @return \CoreBundle\Entity\CategoryEntity
     */
    public function getCategoryEntity(String $categoryPath)
    {
        $categoryPathArray = new CategoryPathArray($categoryPath, $this->categoryService);
        $categoryEntity = null;
        foreach ($categoryPathArray as $categoryPath) {
            $categoryEntity = $categoryPath;
        }

        return $categoryEntity;
    }

}