<?php

namespace MetaTemplate\Template;

use CoffeeScript\Compiler,
    CoffeeScript\Error;

class PHPCoffeeScriptTemplate extends Base
{
    static function getDefaultContentType()
    {
        return "application/javascript";
    }

    function render($context = null, $vars = array())
    {
        try {
            return Compiler::compile($this->data);
        } catch (Error $e) {
            throw new \RuntimeException(
                "coffee({$this->source}) returned an error:\n {$e->getMessage()}"
            );
        }
    }
}
