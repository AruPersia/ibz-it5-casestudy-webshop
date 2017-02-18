<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\Category;
use CoreBundle\Model\CategoryBuilder;
use Tests\CoreBundle\Boot\KernelTestCaseWithDbSupport;

class CategoryServiceTest extends KernelTestCaseWithDbSupport
{

    public function testCreateCategoryShouldWorkProperly()
    {
        // given
        $category = $this->createDefaultCategory();

        // when
        $createdCategory = $this->categoryService()->create($category);

        // then
        $this->assertNotNull($createdCategory);
    }

    private function createDefaultCategory(): Category
    {
        return CategoryBuilder::instance()
            ->setPath('A')
            ->addChild(CategoryBuilder::instance()->setPath('A1'))
            ->addChild(CategoryBuilder::instance()->setPath('A2'))
            ->addChild(CategoryBuilder::instance()->setPath('A3'))
            ->createNode('B')
            ->addChild(CategoryBuilder::instance()->setPath('B1'))
            ->addChild(CategoryBuilder::instance()->setPath('B2'))
            ->addChild(CategoryBuilder::instance()->setPath('B3'))
            ->createNode('C')
            ->addChild(CategoryBuilder::instance()->setPath('C1'))
            ->addChild(CategoryBuilder::instance()->setPath('C2'))
            ->addChild(CategoryBuilder::instance()->setPath('C3'))
            ->build();
    }

}