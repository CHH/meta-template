<?php

namespace MetaTemplate;

use MetaTemplate\Util\EngineRegistry;

class Template
{
    static protected $engines;

    static function getEngines()
    {
        if (null === static::$engines) {
            static::$engines = new EngineRegistry;
        }
        return static::$engines;
    }

    /**
     * Returns the engine class for the given path
     *
     * @param  string $template The Template File's Path
     * @return string
     */
    static function get($template)
    {
        $ext = pathinfo($template, PATHINFO_EXTENSION);
        return static::getEngines()->get($ext);
    }

    /**
     * Creates a engine instance for the given template path
     *
     * @param  string $template
     * @param  array  $options  Engine Options to pass to the constructor
     * @return \Pipe\Template\Base
     */
    static function create($template, array $options = array())
    {
        $class    = static::get($template);
        $template = new $class($template, $options);

        return $template;
    }

    /**
     * Registers an engine with an file extension
     *
     * @param  string $engine The Engine Class
     * @param  string|array $extension One ore more extensions
     * @return void
     */
    static function register($engine, $extension)
    {
        static::getEngines()->register($engine, $extension);
    }

    static function normalizeExtension($extension)
    {
        $extension = strtolower($extension);

        if ('.' == $extension[0]) {
            $extension = substr($extension, 1);
        }
        return $extension;
    }
}

Template::register('\\MetaTemplate\\Template\\PhpTemplate', array('php', 'phtml'));
