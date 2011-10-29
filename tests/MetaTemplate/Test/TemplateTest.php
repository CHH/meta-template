<?php

namespace MetaTemplate\Test;

use MetaTemplate\Template;

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
}
