<?php

namespace MetaTemplate\Test\Template;

use MetaTemplate\Template\PHPTemplate;

class PHPTemplateTest extends \PHPUnit_Framework_TestCase
{
    function testRendersEmptyContextWithSingleVariable()
    {
        $templ = new PHPTemplate(__DIR__ . "/fixtures/php/test.phtml");
        $output = $templ->render(new \StdClass, array('name' => 'Jim'));

        $this->assertEquals("Hello World Jim!\n", $output);
    }

    function testRendersTemplateWithContext()
    {
        $templ = new PHPTemplate(function() {
            return 'You won <?= $this->amount; ?> $.';
        });

        $context = (object) array(
            'amount' => 40000
        );
        $output = $templ->render($context);

        $this->assertEquals("You won 40000 $.", $output);
    }

    function testRendersWithShortTagsWithoutSemicolons()
    {
        $templ = new PHPTemplate(function() {
            return 'You won <?= $this->amount ?> $.';
        });

        $context = (object) array(
            'amount' => 40000
        );

        $output = $templ->render($context);

        $this->assertEquals("You won 40000 $.", $output);
    }
}
