<?php
namespace AppBundle\Controller;

use AppBundle\Form\CustomerFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends WebShopController
{

    /**
     * @param Request $request
     * @A\Route("/customer/create", name="customerCreate")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        return $this->render('customer/create.html.twig', ['form' => $this->getCustomerForm()->createView()]);
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getCustomerForm()
    {
        return $this->createForm(CustomerFormType::class);
    }

    /**
     * @param Request $request
     * @A\Route("/customer/save", name="customer.save")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(Request $request)
    {
        $customerForm = $this->getCustomerForm()->handleRequest($request);
        if ($customerForm->isValid()) {
            $this->getCustomerService()->save($customerForm->getData());
            return $this->render('default/index.html.twig');
        }
        return $this->render('customer/create.html.twig', ['form' => $customerForm->createView()]);
    }

    /**
     *
     * @param Int $customerId
     * @A\Route("/customer/delete/{customerId}")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Int $customerId)
    {
        $this->getCustomerService()->delete($customerId);
        return $this->render('default/index.html.twig');
    }

}