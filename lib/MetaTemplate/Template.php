<?php

namespace MetaTemplate;

use MetaTemplate\Util\EngineRegistry;

class Template
{
    /** @var EngineRegistry */
    static protected $engines;

    static function getEngines()
    {
        if (null === static::$engines) {
            static::$engines = new EngineRegistry;
        }
        return static::$engines;
    }

    static function setDefaultOptions($engine, $options = array())
    {
        static::getEngines()->setDefaultOptions($engine, $options);
    }

    /**
     * Returns the engine class for the given path
     *
     * @param  string $template The Template File's Path
     * @return string
     */
    static function get($template)
    {
        $ext = pathinfo(basename($template), PATHINFO_EXTENSION);
        return static::getEngines()->get($ext);
    }

    /**
     * Creates a engine instance for the given template path
     *
     * @param  string $source
     * @param  array  $options  Engine Options to pass to the constructor
     * @return \MetaTemplate\Template\Base
     */
    static function create($source, $options = array(), $callback = null)
    {
        return static::getEngines()->create($source, $options, $callback);
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

    static function setupDefaultEngines()
    {
        static::register('\\MetaTemplate\\Template\\PhpTemplate', array('php', 'phtml'));
        static::register('\\MetaTemplate\\Template\\LessTemplate', 'less');
        static::register('\\MetaTemplate\\Template\\MarkdownTemplate', array('markdown', 'md'));
        static::register('\\MetaTemplate\\Template\\CoffeeScriptTemplate', 'coffee');
        static::register('\\MetaTemplate\\Template\\TwigTemplate', 'twig');
    }
}

Template::setupDefaultEngines();

