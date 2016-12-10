<?php

namespace AppBundle\Controller;

use AppBundle\Model\Image;
use AppBundle\Model\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{

    /**
     * @Route("/product/{productId}", name="showProduct")
     * @param $productId
     */
    public function showAction($productId)
    {
        // TODO: Load product from database using $productId

        $product = new Product($productId, 'Galaxy S7', new Image('loadImageContentFromDb'));

        return $this->render('product/show.product.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/products", name="showProducts")
     */
    public function showProducts()
    {
        $products = [
            new Product(1, 'Galaxy S1', new Image('loadImageContentFromDb')),
            new Product(2, 'Galaxy S2', new Image('loadImageContentFromDb')),
            new Product(3, 'Galaxy S3', new Image('loadImageContentFromDb')),
            new Product(4, 'Galaxy S4', new Image('loadImageContentFromDb')),
            new Product(5, 'Galaxy S5', new Image('loadImageContentFromDb')),
            new Product(6, 'Galaxy S6', new Image('loadImageContentFromDb')),
            new Product(7, 'Galaxy S7', new Image('loadImageContentFromDb'))];

        return $this->render('product/show.products.html.twig', ['products' => $products]);
    }
}
