<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\CategoryData;
use CoreBundle\Entity\CategoryEntityBuilder;

class CategoryService extends \CoreBundle\Service\Db\CategoryService
{

    /**
     * @param CategoryData $categoryData
     * @return CategoryEntityBuilder|null
     */
    public function createCategoryByPath(CategoryData $categoryData)
    {
        $categoryEntity = $this->assembleCategoryByPath($categoryData->getPath());
        $this->em->flush();
        return $categoryEntity;
    }

    /**
     * @param String $path
     * @return CategoryEntityBuilder
     */
    public function assembleCategoryByPath(String $path)
    {
        $categoryPathArray = new CategoryPathArray($path, $this);

        $categoryEntity = null;
        foreach ($categoryPathArray as $categoryPath) {
            $categoryEntity = $categoryPath;
        }

        return $categoryEntity;
    }

    /**
     * @param String $categoryName
     * @param String $path
     * @param CategoryEntityBuilder|null $parentCategoryEntity
     * @return CategoryEntityBuilder
     */
    public function createCategory(String $categoryName, String $path, CategoryEntityBuilder $parentCategoryEntity = null)
    {
        $categoryEntity = new CategoryEntityBuilder();
        $categoryEntity->setName($categoryName);
        $categoryEntity->setPath(rtrim($path, '/'));
        $categoryEntity->setParent($parentCategoryEntity);
        $this->em->persist($categoryEntity);
        return $categoryEntity;
    }

    public function findByNameAndCategoryId(String $categoryName, $categoryId = null)
    {
        return $this->getCategoryRepository()->findOneBy(['name' => $categoryName, 'parentCategory' => $categoryId]);
    }

    /**
     * @return CategoryEntityBuilder[]
     */
    public function findAll()
    {
        return $this->getCategoryRepository()->findAll();
    }

}