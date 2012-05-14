<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process;

class LessTemplate extends Base
{
    const DEFAULT_LESSC = "/usr/bin/env lessc";

    # The location of the "lessc" executable.
    static $bin = self::DEFAULT_LESSC;

    static function getDefaultContentType()
    {
        return "text/css";
    }

    function render($context = null, $vars = array())
    {
        $options  = $this->options;
        $compress = @$options["compress"] ?: false;

        if ($this->isFile()) {
            $inputFile = $this->source;
        } else {
            $inputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_input');
            file_put_contents($inputFile, $this->data);
        }

        $outputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_output');

        $cmd = static::$bin;

        if ($compress) {
            $cmd .= ' -x';
        }

        $cmd .= " $inputFile $outputFile";

        $process = new Process($cmd);

        $process->setEnv(array(
            'PATH' => $_SERVER['PATH']
        ));

        $process->run();
        $content = file_get_contents($outputFile);

        unlink($outputFile);

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "lessc returned an error: " . $process->getErrorOutput()
            );
        }

        return $content;
    }
}
