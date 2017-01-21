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
        return $this->render('@Frontend/base.html.twig', $this->getDefaultParameters($category->getChildren(), $categoryPath, $category->getProducts()));
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        if (!array_key_exists('categories', $parameters)) {
            $parameters = array_merge($parameters, $this->getDefaultParameters($this->getRootCategories()));
        }

        $parameters['shoppingCart'] = $this->getShoppingCartService();

        return parent::render($view, $parameters, $response);
    }

    private function getDefaultParameters($categories, $categoryPath = null, $products = array())
    {
        $parameters = array();
        $parameters['categories'] = $categories;
        $parameters['breadcrumbs'] = array_filter(explode('/', $categoryPath));
        $parameters['products'] = $products;
        return $parameters;
    }

    /**
     * @return CategoryEntity[]
     */
    private function getRootCategories()
    {
        return $this->getCategoryService()->findAllRootCategories();
    }

    /**
     * @A\Route("/", name="frontendShowAllRootCategories")
     * @return Response
     */
    public function showAllRootCategories()
    {
        return $this->render('@Frontend/base.html.twig', $this->getDefaultParameters($this->getRootCategories()));
    }


}