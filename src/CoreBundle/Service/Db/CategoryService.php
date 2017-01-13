<?php

namespace CoreBundle\Service\Db;

class CategoryService extends EntityManagerService
{
    /**
     * @param String $categoryName
     * @return \CoreBundle\Entity\CategoryEntity|null
     */
    public function findByName(String $categoryName)
    {
        return $this->getCategoryRepository()->findOneBy(['name' => $categoryName]);
    }

    protected function getCategoryRepository()
    {
        return $this->em->getRepository('CoreBundle:CategoryEntity');
    }

    /**
     * @param String $path
     * @return \CoreBundle\Entity\CategoryEntity
     */
    public function findByPath(String $path)
    {
        return $this->getCategoryRepository()->findOneBy(['path' => $path]);
    }

}