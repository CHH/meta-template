<?php

namespace MetaTemplate\Util;

use MetaTemplate\Template;

class EngineRegistry
{
    protected $engines = array();
    protected $defaultOptions = array();

    function getEngines()
    {
        return $this->engines;
    }

    function setDefaultOptions($engine, $options = array())
    {
        $this->defaultOptions[$engine] = $options;
    }

    /**
     * Registers an engine with one or more extensions
     *
     * @param  string $engine Engine Class
     * @param  string|array $extension One or more extensions
     * @return EngineRegistry
     */
    function register($engine, $extension)
    {
        if (!class_exists($engine)) {
            throw new \InvalidArgumentException("Class $engine is not defined");
        }

        if (!class_implements($engine, "\\MetaTemplate\\Template\\TemplateInterface")) {
            throw new \InvalidArgumentException(
                "An engine must implement \\MetaTemplate\\Template\\TemplateInterface."
            );
        }

        $extensions = (array) $extension;

        foreach ($extensions as $extension) {
            $extension = Template::normalizeExtension($extension);
            $this->engines[$extension] = $engine;
        }

        return $this;
    }

    function create($source, $options = null, $callback = null)
    {
        $extension = pathinfo($source, PATHINFO_EXTENSION);
        $class = $this->get($extension);
        $options = array_merge(@$this->defaultOptions[$class] ?: array(), $options);

        return new $class($source, $options, $callback);
    }

    function get($extension)
    {
        $extension = Template::normalizeExtension($extension);

        if (empty($this->engines[$extension])) {
            return;
        }
        return $this->engines[$extension];
    }
}
