<?php

namespace MetaTemplate\Template;

use jsonbuilder\Object;

class JSONBuilderTemplate extends PhpTemplate
{
    static function getDefaultContentType()
    {
        return "application/json";
    }

    function render($context = null, $vars = array())
    {
        $json = new Object;

        $vars['json'] = $json;
        parent::render($context, $vars);

        return (string) $json;
    }
}
