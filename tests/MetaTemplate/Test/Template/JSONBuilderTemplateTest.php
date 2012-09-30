<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\JSONBuilderTemplate;

class JSONBuilderTemplateTest extends \PHPUnit_Framework_TestCase
{
    function test()
    {
        $context = (object) array('foo' => 'bar');

        $templ = new JSONBuilderTemplate(__DIR__ . '/fixtures/jsonbuilder/test.jsonbuilder');
        $json = $templ->render($context);

        $this->assertEquals('{"foo":"bar"}', $json);
    }

    function testExtensionRegistered()
    {
        $templ = \MetaTemplate\Template::create(__DIR__ . '/fixtures/jsonbuilder/test.jsonbuilder');

        $this->assertInstanceOf('\\MetaTemplate\\Template\\JSONBuilderTemplate', $templ);
    }
}
