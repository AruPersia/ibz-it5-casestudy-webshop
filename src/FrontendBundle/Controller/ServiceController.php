<?php

namespace FrontendBundle\Controller;

use CoreBundle\Controller\CoreController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

class ServiceController extends CoreController
{

    /**
     * @return \FrontendBundle\Service\Db\RegistrationService
     */
    protected function getRegistrationService()
    {
        return $this->get('frontend.service.db.registration');
    }

    /**
     * @return \FrontendBundle\Service\Db\CategoryService
     */
    protected function getCategoryService()
    {
        return $this->get('frontend.service.db.frontend.category');
    }

    /**
     * @return \FrontendBundle\Service\ShoppingCart\DbShoppingCartService
     */
    protected function getShoppingCartService()
    {
        return $this->get('frontend.service.shopping.cart');
    }

}
