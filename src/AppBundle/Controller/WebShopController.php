<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WebShopController extends Controller
{

    /**
     * @return \AppBundle\Service\Db\CustomerService|object
     */
    public function getCustomerService()
    {
        return $this->get('services.db.customer');
    }

    public function getProductService()
    {
        return $this->get('services.db.product');
    }

    public function isPostRequest(Request $request)
    {
        return $request->isMethod('POST');
    }

    public function addError($errorMessage)
    {
        $this->addFlash('error', $errorMessage);
    }

    public function addSuccess($successMessage)
    {
        $this->addFlash('success', $successMessage);
    }


}