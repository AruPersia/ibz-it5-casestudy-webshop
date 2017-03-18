<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Entity\CategoryEntityBuilder;
use CoreBundle\Model\Category;
use CoreBundle\Model\PathBuilder;

class CategoryMapper
{

    /**
     * @param CategoryEntity $categoryEntity
     * @return Category
     */
    public static function mapToCategory(CategoryEntity $categoryEntity): Category
    {
        return new Category($categoryEntity->getId(), PathBuilder::createByPath($categoryEntity->getPath()));
    }

    /**
     * @param $categoryEntities
     * @return Category[]
     */
    public static function mapToCategories($categoryEntities)
    {
        $categories = array();
        foreach ($categoryEntities as $categoryEntity) {
            $categories[] = self::mapToCategory($categoryEntity);
        }
        return $categories;
    }

}