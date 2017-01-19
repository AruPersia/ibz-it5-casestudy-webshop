<?php

namespace BackendBundle\Controller;

use CoreBundle\Controller\CoreController;

class BackendController extends CoreController
{

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

    /**
     * @return \CoreBundle\Repository\SecurityRepository
     */
    protected function getAdministratorRepository()
    {
        return $this->getEntityManager()->getRepository('BackendBundle:AdministratorEntity');
    }

}