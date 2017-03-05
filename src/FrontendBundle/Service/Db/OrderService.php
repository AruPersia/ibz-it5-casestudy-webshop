<?php

namespace FrontendBundle\Service\Db;

use CoreBundle\Entity\OrderEntity;
use CoreBundle\Model\Address;
use CoreBundle\Model\Order;
use CoreBundle\Model\OrderLine;
use CoreBundle\Repository\AddressRepository;
use CoreBundle\Repository\OrderRepository;
use CoreBundle\Service\Db\OrderMapper;
use Doctrine\ORM\EntityManager;

class OrderService extends \CoreBundle\Service\Db\OrderService
{

    private $addressRepository;

    public function __construct(EntityManager $entityManager, OrderRepository $orderRepository, AddressRepository $addressRepository)
    {
        parent::__construct($entityManager, $orderRepository);
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param $customerId
     * @param Address $deliveryAddress
     * @param OrderLine[] $orderLines
     * @return Order
     */
    public function create($customerId, Address $deliveryAddress, $orderLines): Order
    {
        $addressEntity = $this->addressRepository->create(
            $deliveryAddress->getStreet(),
            $deliveryAddress->getHouseNumber(),
            $deliveryAddress->getPostCode(),
            $deliveryAddress->getCity());

        $orderEntity = OrderEntity::instance()
            ->setCustomer($this->orderRepository->customerEntityRefById($customerId))
            ->setDeliveryAddress($addressEntity)
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