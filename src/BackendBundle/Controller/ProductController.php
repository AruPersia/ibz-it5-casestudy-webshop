<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ProductData;
use CoreBundle\Message\Message;
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
        $products = $this->productService()->findByPath('/', true);
        return $this->render('@Backend/products.html.twig', ['products' => $products]);
    }

    /**
     * @param $id - Product id
     * @Route("/product/edit/{id}", name="backend_product_edit", requirements={"id": "\d+"})
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productService()->findById($id);
        $productData = $this->buildProductData($product);
        $productEditForm = $this->updateProductForm($productData);
        return $this->renderProductEditForm($productEditForm, $product);
    }

    /**
     * @Route("/product/edit/submit", name="backend_product_edit_submit")
     */
    public function submitEdit()
    {
        $productData = new ProductData();
        $productEditForm = $this->updateProductForm($productData)->handleRequest($this->getRequest());
        $product = $this->productService()->findById($productData->getId());
        if ($productEditForm->isValid()) {
            $this->productService()->update($productData);
        }

        return $this->redirectToRoute('backend_product_edit', ['id' => $product->getId()]);
    }

    /**
     * @param $id
     * @param $imageId
     * @Route("/product/edit/{id}/main/image/{imageId}", name="backend_product_change_image")
     * @return Response
     */
    public function changeMainImage($id, $imageId)
    {
        $product = $this->productService()->changeMainImage($id, $imageId);
        $productData = $this->buildProductData($product);
        $productEditForm = $this->updateProductForm($productData);
        return $this->renderProductEditForm($productEditForm, $product);
    }

    /**
     * @param $id - Product id
     * @Route("/product/{id}/toggle/status", name="backend_product_toggle_status")
     * @return Response
     */
    public function toggleStatus($id)
    {
        $this->productService()->toggleStatus($id);
        return $this->index();
    }

    /**
     * @Route("/product/create", name="backend_product_create")
     */
    public function create()
    {
        return $this->renderProductForm($this->createProductForm());
    }

    /**
     * @Route("/product/create/submit", name="backend_product_create_submit")
     */
    public function submitCreate()
    {
        $productForm = $this->createProductForm()->handleRequest($this->getRequest());

        if (!$productForm->isValid()) {
            return $this->renderProductForm($productForm);
        }

        $this->productService()->create($productForm->getData());
        return $this->renderProductForm($productForm);
    }

    /**
     * @param $productId
     * @Route("/product/delete/{productId}", name="backend_product_delete")
     * @return Response
     */
    public function delete($productId)
    {
        $product = $this->productService()->deleteById($productId);
        $this->addMessage(Message::success('Product deleted', $product->getName()));
        return $this->index();
    }

    private function renderProductForm(Form $form): Response
    {
        return $this->render('@Backend/product.create.form.html.twig', ['productForm' => $form->createView()]);
    }

    private function renderProductEditForm(Form $form, Product $product): Response
    {
        return $this->render('@Backend/product.edit.html.twig', [
            'productForm' => $form->createView(),
            'product' => $product
        ]);
    }

    private function buildProductData(Product $product): ProductData
    {
        $productData = new ProductData();
        $productData->setId($product->getId());
        $productData->setName($product->getName());
        $productData->setCategoryPath($product->getCategory()->getPath());
        $productData->setDescription($product->getDescription());
        $productData->setStockQuantity($product->getStockQuantity());
        $productData->setPrice($product->getPrice());
        return $productData;
    }

}