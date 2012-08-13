<?php

namespace MetaTemplate;

use MetaTemplate\Util\EngineRegistry;
use CHH\FileUtils;

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
        return FileUtils::normalizeExtension($extension);
    }

    static function setupDefaultEngines()
    {
        $defaultEngines = array(
            'PhpTemplate'          => array('php', 'phtml'),
            'LessTemplate'         => array('less'),
            'MarkdownTemplate'     => array('md', 'markdown'),
            'CoffeeScriptTemplate' => array('coffee'),
            'TwigTemplate'         => array('twig')
        );

        foreach ($defaultEngines as $engine => $extensions) {
            static::register("\\MetaTemplate\\Template\\$engine", $extensions);
        }
    }
}

Template::setupDefaultEngines();

