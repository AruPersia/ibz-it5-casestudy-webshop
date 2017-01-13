<?php

namespace FrontendBundle\Service\Db;

class CategoryService extends \CoreBundle\Service\Db\CategoryService
{

    public function findAllRootCategories()
    {
        return $this->getCategoryRepository()->findBy(['parentCategory' => null]);
    }

}