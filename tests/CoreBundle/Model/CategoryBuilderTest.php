<?php

namespace Tests\CoreBundle\Model;

use CoreBundle\Model\Category;
use CoreBundle\Model\CategoryBuilder;

class CategoryBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateCategoryShouldWorkProperly()
    {
        // when
        $category = CategoryBuilder::instance()
            ->setPath('PC')
            ->addChild(CategoryBuilder::instance()->setPath('Components'))
            ->addChild(CategoryBuilder::instance()->setPath('Peripherals'))
            ->addChild(CategoryBuilder::instance()->setPath('Mice'))
            ->build();

        // then
        $this->assertEquals('PC', $category->getPath());
        $this->assertPath('PC/Components', $category->getChildren()[0]);
        $this->assertPath('PC/Peripherals', $category->getChildren()[1]);
        $this->assertPath('PC/Mice', $category->getChildren()[2]);
    }

    public function testCreateCategoryHierarchyShouldWorkProperly()
    {
        // when
        $category = CategoryBuilder::instance()
            ->setPath('PC')
            ->createNode('Components')
            ->createNode('Peripherals')
            ->createNode('Mice')
            ->build();

        // then
        $category = $this->assertPath('PC', $category);
        $category = $this->assertPath('PC/Components', $category->getChildren()[0]);
        $category = $this->assertPath('PC/Components/Peripherals', $category->getChildren()[0]);
        $category = $this->assertPath('PC/Components/Peripherals/Mice', $category->getChildren()[0]);
        $this->assertEmpty($category->getChildren());

        $category = $this->assertPath('PC/Components/Peripherals', $category->getParent());
        $category = $this->assertPath('PC/Components', $category->getParent());
        $category = $this->assertPath('PC', $category->getParent());
        $this->assertNull($category->getParent());

    }

    private function assertPath($expected, Category $actualCategory)
    {
        $this->assertEquals($expected, $actualCategory->getPath());
        return $actualCategory;
    }

}