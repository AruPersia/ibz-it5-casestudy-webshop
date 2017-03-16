<?php

namespace FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

abstract class CategoryController extends ServiceController
{

    /**
     * @param $name - Currency name
     * @Route("/currency/{name}", name="change_currency")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeCurrency($name)
    {
        $this->currencyService()->setOutputCurrency($name);
        return $this->redirectToRoute('catalogue');
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $categoryPath = $this->getCurrentCategoryPath();
        $parameters['category'] = $this->categoryService()->findByPath($categoryPath);
        $parameters['categories'] = $this->categoryService()->findChildren($parameters['category']);
        $parameters['currencies'] = $this->currencyService()->getCurrencyManager()->getRates();
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