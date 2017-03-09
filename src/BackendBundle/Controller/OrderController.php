<?php

namespace BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('admin')")
 */
class OrderController extends ServiceController
{

    /**
     * @Route("/orders", name="backend_orders")
     */
    public function index()
    {
        $openOrders = $this->orderService()->findOpenOrders();
        $completedOrders = $this->orderService()->findCompletedOrders(20);
        return $this->render('@Backend/orders.html.twig', ['openOrders' => $openOrders, 'completedOrders' => $completedOrders]);
    }

    /**
     * @param $id - orderId
     * @Route("/order/{id}", name="backend_order_detail")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail($id)
    {
        $order = $this->orderService()->findById($id);
        return $this->render('@Backend/order.detail.html.twig', ['order' => $order]);
    }

}