<?php

namespace AdminBundle\Controller;

use Core\Controller\CoreController;

class AdminController extends CoreController
{

    /**
     * @return \AdminBundle\Service\LoginService
     */
    protected function loginService()
    {
        return $this->get('admin.service.login');
    }

}