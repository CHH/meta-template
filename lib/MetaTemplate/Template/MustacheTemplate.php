<?php

namespace MetaTemplate\Template;

use Phly\Mustache\Mustache;

class MustacheTemplate extends Base
{
    protected $mustache;

    static function getDefaultContentType()
    {
        return "text/html";
    }

    function render($context = null, $vars = array())
    {
        $mustache = $this->getMustache();

        $tokens = $mustache->getLexer()->compile($this->data, $this->source);
        return $mustache->getRenderer()->render($tokens, $context);
    }

    function getMustache()
    {
        if (null === $this->mustache) {
            $this->mustache = new Mustache;
        }
        return $this->mustache;
    }
}
