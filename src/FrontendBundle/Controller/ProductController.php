<?php

namespace FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends CategoryController
{

    /**
     * @Route("/", defaults={"categoryPath": "/"})
     * @Route("/catalogue{categoryPath}", name="catalogue", requirements={"categoryPath": ".+"}, defaults={"categoryPath": "/"})
     * @param $categoryPath - Category path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($categoryPath)
    {
        $products = $this->productService()->findByPath($categoryPath);
        return $this->render('@Frontend/products.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/product/{id}", name="show_product")
     */
    public function showProduct($id)
    {
        $product = $this->productService()->findById($id);
        return $this->render('@Frontend/product.html.twig', ['product' => $product]);
    }

}