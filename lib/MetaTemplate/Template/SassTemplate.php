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

        if (strpos($this->getExtension(), 'scss') !== false) {
            $this->parser->syntax = 'scss';
        }
    }

    function render($context = null, $vars = array())
    {
        return $this->parser->toCss($this->getData());
    }
}
