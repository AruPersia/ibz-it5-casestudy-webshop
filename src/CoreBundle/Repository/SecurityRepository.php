<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\SecurityEntity;
use CoreBundle\Form\LoginData;
use CoreBundle\Service\Security\SecurityRepositorySupport;
use Doctrine\ORM\EntityRepository;

class SecurityRepository extends EntityRepository implements SecurityRepositorySupport
{

    /**
     * @param LoginData $loginData
     * @return SecurityEntity
     */
    public function loadUserByEmailAndPassword(LoginData $loginData)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter('email', $loginData->getEmail())
            ->setParameter('password', $loginData->getPassword())
            ->getQuery()->getSingleResult();
    }

}