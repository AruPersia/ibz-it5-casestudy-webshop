<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arash
 * Date: 21.01.2017
 * Time: 00:34
 */

namespace CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{

    /**
     * @return \CoreBundle\Service\Security\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->get('core.service.security');
    }

}