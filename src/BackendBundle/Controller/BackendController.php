<?php

namespace BackendBundle\Controller;

use CoreBundle\Controller\CoreController;

class BackendController extends CoreController
{

    /**
     * @return \BackendBundle\Service\Db\LoginService
     */
    protected function getLoginService()
    {
        return $this->get('backend.service.login');
    }

    /**
     * @return \BackendBundle\Service\Db\ProductService
     */
    protected function getProductService()
    {
        return $this->get('backend.service.product');
    }

    /**
     * @return \BackendBundle\Service\Db\CategoryService
     */
    protected function getCategoryService()
    {
        return $this->get('backend.service.category');
    }

}