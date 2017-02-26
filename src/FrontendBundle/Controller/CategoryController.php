<?php

namespace FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

abstract class CategoryController extends ServiceController
{

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $categoryPath = $this->getCurrentCategoryPath();
        $parameters['category'] = $this->categoryService()->findByPath($categoryPath);
        $parameters['categories'] = $this->categoryService()->findChildren($parameters['category']);
        return parent::render($view, $parameters, $response);
    }

    private function getCurrentCategoryPath(): String
    {
        $categoryPath = $this->getRequest()->attributes->get('categoryPath');
        if ($categoryPath == null || empty($categoryPath)) {
            $categoryPath = '/';
        }

        return $categoryPath;
    }

}