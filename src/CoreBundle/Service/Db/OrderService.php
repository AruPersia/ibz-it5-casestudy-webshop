<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\OrderEntity;
use CoreBundle\Model\Order;
use CoreBundle\Model\OrderLine;
use CoreBundle\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;

class OrderService extends EntityService
{

    private $orderRepository;

    public function __construct(EntityManager $entityManager, OrderRepository $orderRepository)
    {
        parent::__construct($entityManager);
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $customerId
     * @param OrderLine[] $orderLines
     * @return Order
     */
    public function create($customerId, $orderLines): Order
    {

        $orderEntity = OrderEntity::instance()
            ->setCustomer($this->orderRepository->customerEntityRefById($customerId))
            ->setOrderDate(new \DateTime())
            ->setShipmentDate(new \DateTime());

        foreach ($orderLines as $orderLine) {
            $productEntity = $this->orderRepository->productEntityRefById($orderLine->getProduct()->getId());
            $orderEntity->addLine($productEntity, $orderLine->getQuantity());
        }

        $orderEntity = $this->orderRepository->create($orderEntity);
        $this->flush();

        return OrderMapper::mapToOrder($orderEntity);
    }

    /**
     * @param $customerId
     * @return \CoreBundle\Model\Order[]
     */
    public function findByCustomerId($customerId)
    {
        $customerEntity = $this->orderRepository->customerEntityRefById($customerId);
        $orderEntities = $this->orderRepository->findByCustomer($customerEntity);
        return OrderMapper::mapToOrders($orderEntities);
    }

}