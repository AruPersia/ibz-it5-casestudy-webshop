<?php

namespace BackendBundle\Controller;

use CoreBundle\Controller\CoreController;

class BackendController extends CoreController
{

    /**
     * @return \BackendBundle\Service\LoginService
     */
    protected function loginService()
    {
        return $this->get('backend.service.login');
    }

}