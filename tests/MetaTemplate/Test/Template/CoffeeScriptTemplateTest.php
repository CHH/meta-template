<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\CoffeeScriptTemplate;

class CoffeeScriptTemplateTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        if (!isset($_ENV["COFFEE_BIN"])) {
            return $this->markTestSkipped("Set \$_ENV['COFFEE_BIN'] to test Coffeescript support.");
        }
    }

    function test()
    {
        $template = new CoffeeScriptTemplate(__DIR__ . "/fixtures/coffee/test.coffee", array(
            "bin" => $_ENV["COFFEE_BIN"]
        ));

        $output = $template->render();
        $this->assertFalse(empty($output));
    }
}
