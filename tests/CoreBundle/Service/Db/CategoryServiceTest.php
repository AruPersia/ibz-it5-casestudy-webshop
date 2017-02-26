<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\Path;
use CoreBundle\Model\PathBuilder;
use Tests\CoreBundle\Boot\TestWithDb;

class CategoryServiceTest extends TestWithDb
{

    public function testCreateCategoryShouldWorkProperly()
    {
        // given
        $path = $this->createDefaultPath()->build();

        // when
        $category = $this->categoryService()->create($path);

        // then
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk', $category->getPath());
        $parent = $this->assertPath('/PC/Components/Peripherals', $parent);
        $parent = $this->assertPath('/PC/Components', $parent);
        $parent = $this->assertPath('/PC', $parent);
        $this->assertPath('/', $parent);
    }

    public function testNonDuplicatedPathShouldBeCreated()
    {
        // given
        $path = $this->createDefaultPath()->build();
        $pathSsd = $this->createDefaultPath()->createChild('SSD')->build();
        $pathScsi = $this->createDefaultPath()->createChild('SCSI')->build();

        // when
        $category = $this->categoryService()->create($path);
        $categorySsd = $this->categoryService()->create($pathSsd);
        $categoryScsi = $this->categoryService()->create($pathScsi);

        // then
        $this->assertEquals(5, $category->getId());
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk', $category->getPath());
        $parent = $this->assertPath('/PC/Components/Peripherals', $parent);
        $parent = $this->assertPath('/PC/Components', $parent);
        $parent = $this->assertPath('/PC', $parent);
        $this->assertPath('/', $parent);

        $this->assertEquals(6, $categorySsd->getId());
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk/SSD', $categorySsd->getPath());
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk', $parent);
        $parent = $this->assertPath('/PC/Components/Peripherals', $parent);
        $parent = $this->assertPath('/PC/Components', $parent);
        $parent = $this->assertPath('/PC', $parent);
        $this->assertPath('/', $parent);

        $this->assertEquals(7, $categoryScsi->getId());
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk/SCSI', $categoryScsi->getPath());
        $parent = $this->assertPath('/PC/Components/Peripherals/Hard disk', $parent);
        $parent = $this->assertPath('/PC/Components/Peripherals', $parent);
        $parent = $this->assertPath('/PC/Components', $parent);
        $parent = $this->assertPath('/PC', $parent);
        $this->assertPath('/', $parent);
    }

    private function createDefaultPath(): PathBuilder
    {
        return PathBuilder::create('PC')
            ->createChild('Components')
            ->createChild('Peripherals')
            ->createChild('Hard disk');
    }

    private function assertPath(String $expectedPath, Path $path)
    {
        $this->assertEquals($expectedPath, $path->getPath());
        return $path->getParent();
    }

}