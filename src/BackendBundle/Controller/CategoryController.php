<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ProductFormType;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BackendController
{

    /**
     * @A\Route("category/edit", name="backendCategoryEdit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction()
    {
        return $this->render('@Backend/category.edit.html.twig', ['categories' => $this->getCategoryService()->findAll()]);
    }

    /**
     * @A\Route("/product/submit", name="backendProductCreateSubmit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createSubmitAction(Request $request)
    {
        $productForm = $this->getProductForm()->handleRequest($request);
        if ($productForm->isValid()) {
            $this->getProductService()->create($productForm->getData());
            $this->addMessage(Message::success('product.added.successful', 'product.has.been.added'));
        }

        return $this->renderProductForm($productForm);
    }

    private function getProductForm()
    {
        return $this->createForm(ProductFormType::class);
    }

    private function renderProductForm(Form $form)
    {
        return $this->render('@Backend/Product/create.form.html.twig', ['productForm' => $form->createView()]);
    }

}