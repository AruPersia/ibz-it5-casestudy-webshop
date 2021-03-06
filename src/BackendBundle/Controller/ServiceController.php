<?php

namespace BackendBundle\Controller;

use BackendBundle\Service\Db\OrderService;
use BackendBundle\Service\Db\ProductService;
use BackendBundle\Service\Db\ReorderService;
use CoreBundle\Service\Security\SecurityService;

class ServiceController extends FormController
{

    protected function securityService(): SecurityService
    {
        return $this->get('backend.service.db.security');
    }

    protected function productService(): ProductService
    {
        return $this->get('backend.service.product');
    }

    protected function orderService(): OrderService
    {
        return $this->get('backend.service.order');
    }

    protected function reorderService(): ReorderService
    {
        return $this->get('backend.service.reorder');
    }

}