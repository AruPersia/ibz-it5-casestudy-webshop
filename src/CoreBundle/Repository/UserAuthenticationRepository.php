<?php

namespace CoreBundle\Repository;

use BackendBundle\Form\LoginData;
use CoreBundle\Entity\UserAuthentication;
use Doctrine\ORM\EntityRepository;

class UserAuthenticationRepository extends EntityRepository
{

    /**
     * @param LoginData $loginData
     * @return UserAuthentication
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