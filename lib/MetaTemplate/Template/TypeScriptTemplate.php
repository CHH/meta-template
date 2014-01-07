<?php

namespace MetaTemplate\Template;

use Symfony\Component\Process\Process,
    Symfony\Component\Process\ExecutableFinder;

class TypeScriptTemplate extends Base
{
    const DEFAULT_TSC = "tsc";

    static function getDefaultContentType()
    {
        return "application/javascript";
    }

    function render($context = null, $vars = array())
    {
        $finder = new ExecutableFinder;
        $bin = @$this->options["tsc_bin"] ?: self::DEFAULT_TSC;

        $cmd = $finder->find($bin);

        if ($cmd === null) {
            throw new \UnexpectedValueException(
                "'$bin' executable was not found. Make sure it's installed."
            );
        }

        $inputFile = sys_get_temp_dir() . '/pipe_typescript_input_' . uniqid() . '.ts';
        file_put_contents($inputFile, $this->getData());

        $outputFile = tempnam(sys_get_temp_dir(), 'pipe_typescript_output_') . '.js';

        $cmd .= " --out " . escapeshellarg($outputFile) . ' ' . escapeshellarg($inputFile);

        $process = new Process($cmd);

        $process->setEnv(array(
            'PATH' => @$_SERVER['PATH'] ?: join(PATH_SEPARATOR, array("/bin", "/sbin", "/usr/bin", "/usr/local/bin", "/usr/local/share/npm/bin"))
        ));

        if ($this->isFile()) {
            $process->setWorkingDirectory(dirname($this->source));
        }

        $process->run();
        unlink($inputFile);

        if ($process->getErrorOutput()) {
            throw new \RuntimeException(
                "tsc({$this->source}) returned an error:\n {$process->getErrorOutput()}"
            );
        }

        $data = file_get_contents($outputFile);
        unlink($outputFile);

        return $data;
    }
}
