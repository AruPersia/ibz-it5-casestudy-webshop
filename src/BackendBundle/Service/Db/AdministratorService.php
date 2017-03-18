<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\AdministratorData;
use CoreBundle\Model\Administrator;
use CoreBundle\Repository\AdministratorRepository;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;

class AdministratorService extends EntityService
{

    protected $administratorRepository;

    public function __construct(EntityManager $entityManager, AdministratorRepository $administratorRepository)
    {
        parent::__construct($entityManager);
        $this->administratorRepository = $administratorRepository;
    }

    public function create(AdministratorData $administratorData): Administrator
    {
        $administratorEntity = $this->administratorRepository->create(
            $administratorData->getFirstName(),
            $administratorData->getLastName(),
            $administratorData->getEmail(),
            $administratorData->getPasswordData()->getPassword());

        $this->flush();
        return AdministratorMapper::mapToAdministrator($administratorEntity);
    }

}