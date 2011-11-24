<?php

namespace MetaTemplate\Template;

class MarkdownTemplate extends Base
{
    function render($context = null, $vars = array())
    {
        if (!function_exists('Markdown')) {
            throw new \RuntimeException(
                'MetaTemplate\Template\MarkdownTemplate requires php-markdown to be'
                . ' installed.'
            );
        }
        return Markdown($this->data);
    }
}
