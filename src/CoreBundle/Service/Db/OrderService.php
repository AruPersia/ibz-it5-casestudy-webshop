<?php

namespace CoreBundle\Service\Db;

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
     */
    public function create($customerId, $productIds)
    {
        // TODO Load customer dynamic
        $customerEntity = $this->orderRepository->customerEntityRefById($customerId);
        $productEntities = array();
        foreach ($productIds as $id) {
            $productEntities[] = $this->orderRepository->productEntityRefById($id);
        }
        $this->orderRepository->create($customerEntity, $productEntities);

        $this->flush();
    }

    /**
     * @param $customerId
     * @return \CoreBundle\Entity\OrderEntity[]
     */
    public function findByCustomerId($customerId)
    {
        $customerEntity = $this->orderRepository->customerEntityRefById($customerId);
        return $this->orderRepository->findByCustomer($customerEntity);
    }

}