<?php

namespace BackendBundle\Controller;

use BackendBundle\Form\ReorderData;
use CoreBundle\Message\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;

/**
 * @Security("has_role('admin')")
 */
class ReordersController extends ServiceController
{

    /**
     * @Route("/reorders", name="backend_reorders")
     */
    public function index()
    {
        $pending = $this->reorderService()->findPending();
        $delivered = $this->reorderService()->findDelivered(10);
        return $this->render('@Backend/reorders.html.twig', ['reorders' => array_merge($pending, $delivered)]);
    }

    /**
     * @param $productId - Product id
     * @Route("/reorder/create/{productId}", name="backend_create_reorder")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create($productId)
    {
        $today = new \DateTime();
        $twoWeeks = new \DateTime('+ 14 day');
        $reorderDate = ReorderData::instance()
            ->setProductId($productId)
            ->setReorderDate($today)
            ->setExpectedDate($twoWeeks);
        return $this->renderReorderForm($this->createReorderForm($reorderDate));
    }

    /**
     * @Route("/reorder/submit/create", name="backend_reorder_submit_create")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitCreate()
    {
        $reorderData = new ReorderData();
        $reorderForm = $this->createReorderForm($reorderData)->handleRequest($this->getRequest());
        if ($reorderForm->isValid()) {
            $this->reorderService()->create($reorderData->getProductId(), $reorderData->getQuantity(), $reorderData->getReorderDate(), $reorderData->getExpectedDate());
            $this->addMessage(Message::success('Article reordered', 'Reordering was successful'));
        }

        return $this->renderReorderForm($reorderForm);
    }

    /**
     * @param $reorderId - Reorder id
     * @Route("/reorder/{reorderId}/updateDeliveredDate", name="backend_update_delivered_date")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateDeliveredDate($reorderId)
    {
        $this->reorderService()->updateDeliveredDate($reorderId);
        return $this->redirectToRoute('backend_reorders');
    }

    private function renderReorderForm(Form $form)
    {
        return $this->render('@Backend/reorder.create.form.html.twig', ['reorderForm' => $form->createView()]);
    }

}