<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process,
    Symfony\Component\Process\ExecutableFinder;

class LessTemplate extends Base
{
    const DEFAULT_LESSC = "lessc";

    static function getDefaultContentType()
    {
        return "text/css";
    }

    function render($context = null, $vars = array())
    {
        $options  = $this->options;
        $compress = @$options["compress"] ?: false;

        $inputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_input');
        file_put_contents($inputFile, $this->data);

        $outputFile = tempnam(sys_get_temp_dir(), 'metatemplate_template_less_output');

        $finder = new ExecutableFinder;
        $bin = @$this->options["less_bin"] ?: self::DEFAULT_LESSC;

        $cmd = $finder->find($bin);

        if ($cmd === null) {
            throw new \UnexpectedValueException(
                "'$bin' executable was not found. Make sure it's installed."
            );
        }

        if ($compress) {
            $cmd .= ' -x';
        }

        $cmd .= " $inputFile $outputFile";

        $process = new Process($cmd);

        if ($this->isFile()) {
            $process->setWorkingDirectory(dirname($this->source));
        }

        $process->setEnv(array(
            'PATH' => getenv("PATH")
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
