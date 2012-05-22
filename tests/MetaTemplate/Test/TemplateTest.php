<?php

namespace MetaTemplate\Test;

use MetaTemplate\Template;

class DummyTemplate extends \MetaTemplate\Template\Base
{
    function render($context = null, $vars = array())
    {
    }
}

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    function testRegistersExtensionWithTemplate()
    {
        Template::register('\\MetaTemplate\\Template\\PhpTemplate', '.phtml');

        $templ = Template::create(__DIR__ . "/fixtures/template.phtml");

		$this->assertInternalType('object', $templ);
        $this->assertInstanceOf('\\MetaTemplate\\Template\\PhpTemplate', $templ);
    }

	function testReturnsNullIfExtensionHasNoEngine()
	{
		$this->assertNull(Template::get('foo.erb'));
	}

    function testAcceptsArgumentsInAnyOrder()
    {
        $templ = new DummyTemplate(__DIR__.'/fixtures/template.phtml', function() {
            return "Hello World";
        });

        $this->assertEquals("Hello World", $templ->getData());

        $templ = new DummyTemplate(function() {}, array('foo' => 'bar'));

        $this->assertNull($templ->source);
        $this->assertNull($templ->getData());
    }
}
