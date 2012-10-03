<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\TypeScriptTemplate;

class TypeScriptTemplateTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        if (!isset($_ENV["TSC_PATH"])) {
            return $this->markTestSkipped("Set \$_ENV['TSC_PATH'] to test TypeScript support.");
        }

        putenv("PATH=" . join(PATH_SEPARATOR, array(getenv("PATH"), dirname($_ENV["TSC_PATH"]))));
    }

    function test()
    {
        $template = new TypeScriptTemplate(__DIR__ . "/fixtures/typescript/hello.ts");

        $output = $template->render();
        var_dump($output);
        $this->assertFalse(empty($output));
    }
}
