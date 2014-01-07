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

        if (array_key_exists('include_path', $this->options)) {
            $cmd .= sprintf(
                '--include-path %s',
                escapeshellarg(join(PATH_SEPARATOR, (array) $this->options['include_path']))
            );
        }

        $cmd .= " --no-color - $outputFile";

        $process = new Process($cmd);
        $process->setStdin($this->getData());

        if ($this->isFile()) {
            $process->setWorkingDirectory(dirname($this->source));
        }

        $process->setEnv(array(
            'PATH' => getenv("PATH")
        ));

        $process->run();

        $content = @file_get_contents($outputFile);
        @unlink($outputFile);

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "$cmd returned an error: " . $process->getErrorOutput()
            );
        }

        return $content;
    }
}
