<?php

namespace BackendBundle\Controller;

use BackendBundle\Model\Dashboard;
use BackendBundle\Model\Orders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('admin')")
 */
class DashboardController extends ServiceController
{

    /**
     * @Route("/", name="backend_dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@Backend/dashboard.html.twig', ['dashboard' => $this->createDashboard()]);
    }

    private function createDashboard()
    {
        $pendingSize = $this->orderService()->pendingOrdersSize();
        $processedSize = $this->orderService()->processedOrdersSize();
        return new Dashboard(new Orders($pendingSize, $processedSize));
    }

}