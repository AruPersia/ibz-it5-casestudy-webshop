<?php

namespace Tests\CoreBundle\Model;

use CoreBundle\Model\Path;
use CoreBundle\Model\PathBuilder;

class PathBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatePathShouldWorkProperly()
    {
        // when
        $path = PathBuilder::create('PC')->createChild('Components')->createChild('Peripherals')->build();

        // then
        $parent = $this->assertPath('/PC/Components/Peripherals', $path);
        $parent = $this->assertPath('/PC/Components', $parent);
        $parent = $this->assertPath('/PC', $parent);
        $this->assertPath('/', $parent);
    }

    public function testCreateEmptyPathShouldGiveRootElement()
    {
        // when
        $path = PathBuilder::createByPath('');

        // then
        $this->assertNull($path->getParent());
        $this->assertEquals(Path::DELIMITER, $path->getPath());
    }

    private function assertPath(String $expectedPath, Path $path)
    {
        $this->assertEquals($expectedPath, $path->getPath());
        return $path->getParent();
    }

}