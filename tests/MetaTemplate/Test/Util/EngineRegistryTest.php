<?php

namespace MetaTemplate\Test\Util;

use MetaTemplate\Util\EngineRegistry;

class EngineRegistryTest extends \PHPUnit_Framework_TestCase
{
    protected $engines;

    function setUp()
    {
        $this->engines = new EngineRegistry;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testThrowsExceptionIfNotSubClassOfTemplateBase()
    {
        $this->engines->register("\StdClass", '.php');
    }

    function testReturnsNullIfNoEngineFound()
    {
        $this->assertNull($this->engines->get('html'));
    }

    function testRegister()
    {
        $this->engines->register('\MetaTemplate\Template\PHPTemplate', array('.phtml', '.php'));

        $this->assertEquals('\MetaTemplate\Template\PHPTemplate', $this->engines->get('php'));
        $this->assertEquals('\MetaTemplate\Template\PHPTemplate', $this->engines->get('phtml'));
    }
}
