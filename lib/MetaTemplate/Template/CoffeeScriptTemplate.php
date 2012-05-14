<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process;

class CoffeeScriptTemplate extends Base
{
    const DEFAULT_COFFEE = "/usr/bin/env coffee";

    static $bin = self::DEFAULT_COFFEE;

    static function getDefaultContentType()
    {
        return "application/javascript";
    }

    function render($context = null, $vars = array())
    {
        $cmd = static::$bin;
        $cmd .= " -sc";

        $process = new Process($cmd);

        $process->setEnv(array(
            'PATH' => $_SERVER['PATH']
        ));

        $process->setStdin($this->data);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "coffee returned an error: {$process->getErrorOutput()}"
            );
        }

        return $process->getOutput();
    }
}
