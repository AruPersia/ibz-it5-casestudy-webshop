<?php

namespace FrontendBundle\Service\Db;

use CoreBundle\Model\Category;
use CoreBundle\Service\Db\CategoryMapper;

class CategoryService extends \CoreBundle\Service\Db\CategoryService
{

    public function findChildren(Category $category)
    {
        $categoryEntity = $this->categoryRepository->categoryEntityRefById($category->getId());
        return CategoryMapper::mapToCategories($categoryEntity->getChildren());
    }

}