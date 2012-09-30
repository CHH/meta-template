<?php

namespace MetaTemplate\Template;

use JBuilder;

class JBuilderTemplate extends PhpTemplate
{
    static function getDefaultContentType()
    {
        return "application/json";
    }

    function render($context = null, $vars = array())
    {
        $json = new JBuilder;

        $vars['json'] = $json;
        parent::render($context, $vars);

        return (string) $json;
    }
}
