<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\ImageEntity;
use AppBundle\Entity\ProductEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

class ProductController extends WebShopController
{

    /**
     * @A\Route("/product/{productId}", name="showProduct")
     * @param $productId
     */
    public function showAction($productId)
    {
        $productEntity = new ProductEntity();
        $productEntity->setName('Galaxy S7');
        $productEntity->addImage(new ImageEntity());
        $productEntity->addImage(new ImageEntity());
        $productEntity->addImage(new ImageEntity());

        return $this->render('product/show.product.html.twig', ['product' => $productEntity]);
    }

    /**
     * @A\Route("/products", name="showProducts")
     */
    public function showProducts()
    {
        $products = array();
        for ($i = 0; $i < 10; $i++) {
            $product = new ProductEntity();
            $product->setName('Galaxy S' . $i);
            $product->addImage(new ImageEntity());
            $product->addImage(new ImageEntity());
            $products[] = $product;
        }

        return $this->render('product/show.products.html.twig', ['products' => $products]);
    }
}
