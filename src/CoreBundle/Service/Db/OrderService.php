<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;

class OrderService extends EntityService
{

    protected $orderRepository;

    public function __construct(EntityManager $entityManager, OrderRepository $orderRepository)
    {
        parent::__construct($entityManager);
        $this->orderRepository = $orderRepository;
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