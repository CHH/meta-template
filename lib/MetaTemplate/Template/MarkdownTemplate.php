<?php

namespace MetaTemplate\Template;

use dflydev\markdown\MarkdownParser;

class MarkdownTemplate extends Base
{
    protected $markdown;

    static function getDefaultContentType()
    {
        return "text/html";
    }

    protected function prepare()
    {
        $this->markdown = new MarkdownParser;
    }

    function render($context = null, $vars = array())
    {
        return $this->markdown->transformMarkdown($this->data);
    }
}
