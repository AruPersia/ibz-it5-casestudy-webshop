<?php

namespace BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

class DashboardController extends BackendController
{

    /**
     * @A\Route("/dashboard", name="dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard()
    {
        return $this->render('@Backend/Dashboard/dashboard.html.twig');
    }

}