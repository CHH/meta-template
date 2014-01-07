<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\CoffeeScriptTemplate;

class CoffeeScriptTemplateTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        if (!isset($_ENV["COFFEE_PATH"])) {
            return $this->markTestSkipped("Set \$_ENV['COFFEE_PATH'] to test CoffeeScript support.");
        }

        putenv("PATH=" . join(PATH_SEPARATOR, array(getenv("PATH"), dirname($_ENV["COFFEE_PATH"]))));
    }

    function test()
    {
        $template = new CoffeeScriptTemplate(__DIR__ . "/fixtures/coffee/test.coffee");

        $output = $template->render();
        $this->assertFalse(empty($output));
    }
}
