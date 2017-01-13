<?php

namespace BackendBundle\Service\Db;

use CoreBundle\Entity\CategoryEntity;

class CategoryService extends \CoreBundle\Service\Db\CategoryService
{

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

}