<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\TwigTemplate;

class TwigTemplateTest extends \PHPUnit_Framework_TestCase
{
    function test()
    {
        $ctx = (object) array(
            "foo" => "bar"
        );

        $templ = new TwigTemplate(__DIR__ . "/fixtures/twig/test.twig");

        $this->assertEquals(<<<EXPECTED
Hello World John Doe!


bar

EXPECTED
            , $templ->render($ctx, array("name" => "John Doe"))
        );
    }
}
