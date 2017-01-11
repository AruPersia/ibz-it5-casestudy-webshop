<?php

namespace FrontendBundle\Controller;

use CoreBundle\Entity\CategoryEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\HttpFoundation\Response;

class NavigatorController extends ServiceController
{
    /**
     * @A\Route("/category/{categoryPath}", name="frontendShowCategory", requirements={"categoryPath": ".+"})
     * @param $categoryPath
     * @return Response
     */
    public function showCategoryAction($categoryPath)
    {
        $category = $this->getCategoryService()->findByPath($categoryPath);
        return $this->renderCategoriesAndProducts($category->getChildren(), $categoryPath, $category->getProducts());
    }

    private function renderCategoriesAndProducts($categories, $categoryPath = '', $products = array())
    {
        $parameters = array();
        $parameters['categories'] = $categories;
        $parameters['breadcrumbs'] = explode('/', $categoryPath);
        $parameters['products'] = $products;
        return parent::render('@Frontend/base.html.twig', $parameters);
    }

    /**
     * @A\Route("/")
     * @return Response
     */
    public function showAllRootCategories()
    {
        return $this->renderCategoriesAndProducts($this->getRootCategories());
    }

    /**
     * @return CategoryEntity[]
     */
    private function getRootCategories()
    {
        return $this->getCategoryService()->findAllRootCategories();
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters = array_merge($parameters, $this->getDefaultParameters($this->getRootCategories()));
        return parent::render($view, $parameters, $response);
    }

    private function getDefaultParameters($categories, $categoryPath = '', $products = array())
    {
        $parameters = array();
        $parameters['categories'] = $categories;
        $parameters['breadcrumbs'] = explode('/', $categoryPath);
        $parameters['products'] = $products;
        return $parameters;
    }


}