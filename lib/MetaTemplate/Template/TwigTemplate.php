<?php

namespace MetaTemplate\Template;

use Twig_Environment,
    Twig_Loader_String;

class TwigTemplate extends Base
{
    public $environment;

    static function getDefaultContentType()
    {
        return "text/html";
    }

    function prepare()
    {
        $this->environment = new Twig_Environment(new Twig_Loader_String);
    }

    function render($context = null, $vars = array())
    {
        return $this->environment->render($this->getData(), array_merge($vars, array("context" => $context)));
    }
}
