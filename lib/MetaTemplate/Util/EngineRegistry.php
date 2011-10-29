<?php

namespace MetaTemplate\Util;

use MetaTemplate\Template;

class EngineRegistry
{
    protected $engines = array();

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

        if (!is_subclass_of($engine, "\\MetaTemplate\\Template\\Base")) {
            throw new \InvalidArgumentException(sprintf(
                "An engine must be a subclass of \\MetaTemplate\\Template\\Base, subclass 
                of %s given",
                get_parent_class($engine)
            ));
        }

        $extensions = (array) $extension;

        foreach ($extensions as $extension) {
            $extension = Template::normalizeExtension($extension);
            $this->engines[$extension] = $engine;
        }

        return $this;
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
