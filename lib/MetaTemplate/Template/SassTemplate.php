<?php

namespace MetaTemplate\Template;

class SassTemplate extends Base
{
    protected $parser;

    static function getDefaultContentType()
    {
        return "text/css";
    }

    protected function prepare()
    {
        $this->parser = new \SassParser();
    }

    function render($context = null, $vars = array())
    {
        return $this->parser->toCss($this->data);
    }
}
