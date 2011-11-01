<?php

namespace MetaTemplate\Template;

if (!function_exists('Markdown')) {
    throw new \RuntimeException(
        'MetaTemplate\Template\MarkdownTemplate requires php-markdown to be'
        . ' installed.'
    );
}

class MarkdownTemplate extends Base
{
    function render($context = null, $vars = array())
    {
        return Markdown($this->data);
    }
}
