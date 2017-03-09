<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ProductData;
use CoreBundle\Model\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('admin')")
 */
class ProductController extends ServiceController
{

    /**
     * @Route("/products", name="backend_products")
     */
    public function index()
    {
        $products = $this->productService()->findByPath('/');
        return $this->render('@Backend/products.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/product/edit/{productId}", name="backend_product_edit")
     */
    public function edit($productId)
    {
        return $this->renderProductEditForm($this->productService()->findById($productId));
    }

    /**
     * @Route("/product/submit/{id}", name="backend_product_edit_submit")
     */
    public function submitEdit()
    {

    }

    /**
     * @Route("/product/create", name="backend_product_create")
     */
    public function create()
    {
        return $this->renderProductForm($this->productForm());
    }

    /**
     * @Route("/product/create/submit", name="backend_product_create_submit")
     */
    public function submitCreate()
    {
        $productForm = $this->productForm()->handleRequest($this->getRequest());

        if (!$productForm->isValid()) {
            return $this->renderProductForm($productForm);
        }

        $this->productService()->create($productForm->getData());
        return $this->renderProductForm($productForm);
    }

    private function renderProductForm(Form $form): Response
    {
        return $this->render('@Backend/product.create.form.html.twig', ['productForm' => $form->createView()]);
    }

    private function renderProductEditForm(Product $product): Response
    {
        $productData = new ProductData();
        $productData->setName($product->getName());
        $productData->setCategoryPath($product->getCategory()->getPath());
        $productData->setDescription($product->getDescription());
        $productData->setPrice($product->getPrice());
        $productForm = $this->productForm($productData);
        return $this->render('@Backend/product.edit.html.twig', [
            'product' => $product,
            'productForm' => $productForm->createView()
        ]);
    }

}