<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arash
 * Date: 22.02.2017
 * Time: 20:17
 */

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
     * @param CustomerEntity $customer
     * @return OrderEntity[]
     */
    public function findByCustomer(CustomerEntity $customer)
    {
        return $this->repository()->findBy(['customer' => $customer]);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:OrderEntity');
    }


}