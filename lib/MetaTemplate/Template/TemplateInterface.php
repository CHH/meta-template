<?php

namespace MetaTemplate\Template;

interface TemplateInterface
{
    public function render($context = null, $vars = array());
}
