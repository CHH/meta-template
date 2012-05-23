<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process,
    Symfony\Component\Process\ExecutableFinder;

class CoffeeScriptTemplate extends Base
{
    const DEFAULT_COFFEE = "coffee";

    static function getDefaultContentType()
    {
        return "application/javascript";
    }

    function render($context = null, $vars = array())
    {
        $finder = new ExecutableFinder;
        $bin = @$this->options["coffee_bin"] ?: self::DEFAULT_COFFEE;

        $cmd = $finder->find($bin);

        if ($cmd === null) {
            throw new \UnexpectedValueException(
                "'$bin' executable was not found. Make sure it's installed."
            );
        }

        $cmd .= " -sc";

        $process = new Process($cmd);

        $process->setEnv(array(
            'PATH' => @$_SERVER['PATH'] ?: join(PATH_SEPARATOR, array("/bin", "/sbin", "/usr/bin", "/usr/local/bin"))
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
