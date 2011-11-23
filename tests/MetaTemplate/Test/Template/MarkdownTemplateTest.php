<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\MarkdownTemplate;

class MarkdownTemplateTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        if (!isset($_ENV['MARKDOWN_LIB'])) {
            $this->markTestSkipped('Set MARKDOWN_LIB in the phpunit config file to run this test');
        }
    }

    function test()
    {
        $templ = new MarkdownTemplate(__DIR__.'/fixtures/markdown/test.md');
        $assertion = file_get_contents(__DIR__.'/fixtures/markdown/test.html');

        $this->assertEquals($assertion, $templ->render());
    }
}
