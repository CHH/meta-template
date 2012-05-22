<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\LessTemplate;

class LessTemplateTest extends \PHPUnit_Framework_TestCase
{
    function test()
    {
        if (empty($_ENV['LESS_BIN'])) {
            return $this->markTestSkipped(
                'Set $_ENV[\'LESS_BIN\'] if you want to test LessTemplate'
            );
        }

        $fixture = __DIR__ . "/fixtures/less/screen.less";
        $template = new LessTemplate($fixture, array("bin" => $_ENV["LESS_BIN"]));

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
