<?php

namespace BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

/**
 * @A\Security("has_role('EMPLOYEE')")
 * @package BackendBundle\Controller
 */
class DashboardController extends BackendController
{

    /**
     * @A\Route("/", name="backendShowDashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard()
    {
        return $this->render('@Backend/dashboard.html.twig');
    }

}