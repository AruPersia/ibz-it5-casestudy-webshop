<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;

class DashboardController extends AdminController
{

    /**
     * @A\Route("/dashboard", name="dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard()
    {
        $this->render('@Admin/Dashboard/dashboard.html.twig');
    }

}