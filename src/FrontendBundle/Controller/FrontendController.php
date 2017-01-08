<?php

namespace FrontendBundle\Controller;

use CoreBundle\Controller\CoreController;
use FrontendBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

class FrontendController extends CoreController
{

    /**
     * @return \FrontendBundle\Service\Db\RegistrationService
     */
    protected function getRegistrationService()
    {
        return $this->get('frontend.service.db.registration');
    }

}
