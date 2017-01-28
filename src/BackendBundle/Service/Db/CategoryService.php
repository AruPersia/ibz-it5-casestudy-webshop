<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\CategoryData;
use CoreBundle\Entity\CategoryEntity;

class CategoryService extends \CoreBundle\Service\Db\CategoryService
{

    /**
     * @param CategoryData $categoryData
     * @return CategoryEntity|null
     */
    public function createCategoryByPath(CategoryData $categoryData)
    {
        $categoryEntity = $this->assembleCategoryByPath($categoryData->getPath());
        $this->em->flush();
        return $categoryEntity;
    }

    /**
     * @param String $path
     * @return CategoryEntity
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
     * @param CategoryEntity|null $parentCategoryEntity
     * @return CategoryEntity
     */
    public function createCategory(String $categoryName, String $path, CategoryEntity $parentCategoryEntity = null)
    {
        $categoryEntity = new CategoryEntity();
        $categoryEntity->setName($categoryName);
        $categoryEntity->setPath(rtrim($path, '/'));
        $categoryEntity->setParentCategory($parentCategoryEntity);
        $this->em->persist($categoryEntity);
        return $categoryEntity;
    }

    public function findByNameAndCategoryId(String $categoryName, $categoryId = null)
    {
        return $this->getCategoryRepository()->findOneBy(['name' => $categoryName, 'parentCategory' => $categoryId]);
    }

    /**
     * @return CategoryEntity[]
     */
    public function findAll()
    {
        return $this->getCategoryRepository()->findAll();
    }

}