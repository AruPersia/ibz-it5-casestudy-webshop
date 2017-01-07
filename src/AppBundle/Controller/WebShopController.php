<?php

namespace AppBundle\Controller;

use Core\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class WebShopController extends CoreController
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


}