<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Order;
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
     * @param $productIds
     * @return Order
     */
    public function create($customerId, $productIds): Order
    {
        // TODO Load customer dynamic
        $customerEntity = $this->orderRepository->customerEntityRefById($customerId);
        $productEntities = array();
        foreach ($productIds as $id) {
            $productEntities[] = $this->orderRepository->productEntityRefById($id);
        }
        $orderEntity = $this->orderRepository->create($customerEntity, $productEntities);

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