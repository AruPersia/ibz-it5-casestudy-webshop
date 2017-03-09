<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\CategoryFormType;
use BackendBundle\Form\ProductFormType;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @A\Security("has_role('EMPLOYEE')")
 * @package BackendBundle\Controller
 */
class CategoryController extends ServiceController
{

    /**
     * @A\Route("category/create", name="backendCategoryCreate")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        return $this->renderCategoryForm($this->getCategoryForm());
    }

    /**
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderCategoryForm(Form $form)
    {
        return $this->render('@Backend/category.create.form.html.twig', ['categoryForm' => $form->createView()]);
    }

    private function getCategoryForm()
    {
        return $this->createForm(CategoryFormType::class);
    }

    /**
     * @A\Route("category/create/submit", name="backendCategoryCreateSubmit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createSubmitAction(Request $request)
    {
        $categoryForm = $this->getCategoryForm()->handleRequest($request);
        if ($categoryForm->isValid()) {
            $this->getCategoryService()->createCategoryByPath($categoryForm->getData());
            $this->addMessage(Message::success('successful.saved', 'category.added.successful'));
        }

        return $this->renderCategoryForm($categoryForm);
    }

    /**
     * @A\Route("category/edit", name="backendCategoryEdit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction()
    {
        return $this->render('@Backend/category.edit.html.twig', ['categories' => $this->getCategoryService()->findAll()]);
    }

    private function getProductForm()
    {
        return $this->createForm(ProductFormType::class);
    }

}