<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ProductFormType;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @package BackendBundle\Controller
 * @A\Security("has_role('EMPLOYEE')")
 */
class ProductController extends BackendController
{

    /**
     * @A\Route("product/edit", name="backendProductEdit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction()
    {
        return $this->render('@Backend/product.edit.html.twig', ['products' => $this->getProductService()->findAll()]);
    }

    /**
     * @A\Route("/product/create", name="backendProductCreate")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        return $this->renderProductForm($this->getProductForm());
    }

    private function renderProductForm(Form $form)
    {
        return $this->render('@Backend/product.create.form.html.twig', ['productForm' => $form->createView()]);
    }

    private function getProductForm()
    {
        return $this->createForm(ProductFormType::class);
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

}