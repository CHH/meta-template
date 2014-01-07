<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\LessTemplate;

class LessTemplateTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        if (empty($_ENV['LESS_PATH'])) {
            return $this->markTestSkipped(
                'Set $_ENV[\'LESS_PATH\'] if you want to test LessTemplate'
            );
        }

        putenv("PATH=" . join(PATH_SEPARATOR, array(getenv("PATH"), dirname($_ENV["LESS_PATH"]))));
    }

    function test()
    {
        $fixture = __DIR__ . "/fixtures/less/screen.less";
        $template = new LessTemplate($fixture);

        $assert = <<<CSS
#nav-main {
  border-radius: 6px;
  -moz-border-radius: 6px;
  -webkit-border-radius: 6px;
}
#nav-sub {
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
}

CSS;

        $this->assertEquals($assert, $template->render());
    }
}
