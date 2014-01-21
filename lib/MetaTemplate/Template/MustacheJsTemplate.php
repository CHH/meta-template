<?php

namespace MetaTemplate\Template;

use CHH\MustacheJsCompiler\MustacheJsCompiler;
use Phly\Mustache\Mustache;

/**
 * Compiles a Mustache template to a self contained JS function.
 *
 * Options:
 *
 *     - `mustache`: Override the instance of Phly\Mustache\Mustache to
 *       set your own Mustache environment, e.g. to change template lookup paths.
 *
 */
class MustacheJsTemplate extends Base
{
    static function getDefaultContentType()
    {
        return 'application/javascript';
    }

    function prepare()
    {
        $this->mustache = $this->option('mustache', new Mustache);
        $this->compiler = new MustacheJsCompiler($this->mustache);
    }

    function render($context = null, $vars = array())
    {
        return $this->compiler->compile($this->getData());
    }
}
