<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Entity\OrderEntity;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends AbstractRepository
{

    /**
     * @param OrderEntity $orderEntity
     * @return OrderEntity
     */
    public function create(OrderEntity $orderEntity): OrderEntity
    {
        return $this->persist($orderEntity);
    }

    /**
     * @param $id - Order id
     * @return OrderEntity
     */
    public function updateShipmentDate($id): OrderEntity
    {
        return $this->persist($this->findById($id)->setShipmentDate(new \DateTime()));
    }

    /**
     * @param $id
     * @return OrderEntity|null|object
     */
    public function findById($id)
    {
        return $this->repository()->find($id);
    }

    /**
     * @param CustomerEntity $customer
     * @return OrderEntity[]
     */
    public function findByCustomer(CustomerEntity $customer)
    {
        return $this->repository()->findBy(['customer' => $customer]);
    }

    /**
     * @return OrderEntity[]
     */
    public function findOpenOrders()
    {
        return $this->repository()->findBy(['shipmentDate' => null]);
    }

    /**
     * @return OrderEntity[]
     */
    public function findCompletedOrders($maxResults)
    {
        return $this->repository()
            ->createQueryBuilder('o')
            ->where('o.shipmentDate IS NOT NULL')
            ->orderBy('o.shipmentDate', 'DESC')
            ->getQuery()
            ->setMaxResults($maxResults)
            ->getResult();
    }

    public function pendingOrdersSize()
    {
        return $this->repository()
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.shipmentDate IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function processedOrdersSize()
    {
        return $this->repository()
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.shipmentDate IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:OrderEntity');
    }


}