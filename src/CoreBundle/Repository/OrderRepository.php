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
use CoreBundle\Entity\OrderLineEntity;
use CoreBundle\Entity\ProductEntity;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends AbstractRepository
{

    /**
     * @param CustomerEntity $customer
     * @param ProductEntity[] $products
     * @return OrderEntity
     */
    public function create(CustomerEntity $customer, $products): OrderEntity
    {
        $orderEntity = OrderEntity::instance()
            ->setCustomer($customer)
            ->setOrderDate(new \DateTime())
            ->setShipmentDate(new \DateTime());

        $orderLines = $orderEntity->getOrderLines();

        foreach ($products as $product) {
            $line = OrderLineEntity::instance()
                ->setOrder($orderEntity)
                ->setProduct($product)
                ->setQuantity(111)
                ->setPrice($product->getPrice());

            $orderLines->add($line);
        }

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