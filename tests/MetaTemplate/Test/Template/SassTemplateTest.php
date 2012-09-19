<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\SassTemplate;

class SassTemplateTest extends \PHPUnit_Framework_TestCase
{
    function testSassFile()
    {
        $ctx = (object) array(
            "foo" => "bar"
        );

        $templ = new SassTemplate(__DIR__ . "/fixtures/sass/test.sass");

        $this->assertEquals(<<<EXPECTED
.content-navigation {
  border-color: #3bbfce;
  color: #2ca2af; }

.border {
  padding: 8px;
  margin: 8px;
  border-color: #3bbfce; }


EXPECTED
            , $templ->render($ctx)
        );
    }

    function testScssFile()
    {
        $ctx = (object) array(
            "foo" => "bar"
        );

        $templ = new SassTemplate(__DIR__ . "/fixtures/sass/test.scss");

        $this->assertEquals(<<<EXPECTED
.content-navigation {
  border-color: #3bbfce;
  color: #2ca2af; }

.border {
  padding: 8px;
  margin: 8px;
  border-color: #3bbfce; }


EXPECTED
            , $templ->render($ctx)
        );
    }

}
