<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process;

class LessTemplate extends Base
{
    static function getDefaultContentType()
    {
        return "text/css";
    }

    function render($context = null, $vars = array())
    {
        $options = $this->options;

        $lessBin = isset($options['less_bin']) 
            ? $options['less_bin'] : '/usr/local/bin/lessc';

        $compress = isset($options['compress']) 
            ? $options['compress'] : false;

        if ($this->isFile()) {
            $inputFile = $this->source;
        } else {
            $inputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_input');
            file_put_contents($inputFile, $this->data);
        }

        $outputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_output');

        $cmd = $lessBin.' '.$inputFile.' '.$outputFile;

        if ($compress) {
            $cmd .= ' -x';
        }

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
