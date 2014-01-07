<?php

namespace MetaTemplate\Template;

abstract class Base implements TemplateInterface
{
    /**
     * Path of the source file (if any)
     * @var string
     */
    public $source;

    /**
     * Template's content
     * @var string
     */
    protected $data;

    /**
     * Engine specific options
     */
    protected $options = array();

    /**
     * Constructor
     *
     * All arguments are optional and can be passed in any order.
     *
     * @param strinng $source The source file name.
     * @param string $reader Callback which returns the template's 
     *   contents or the template's file name
     * @param array  $options  Engine Options
     */
    function __construct()
    {
        foreach (array_filter(func_get_args()) as $arg) {
            switch (true) {
                case is_callable($arg):
                    $reader = $arg;
                    break;
                case is_string($arg):
                    $this->source = $arg;
                    break;
                case is_array($arg):
                    $this->options = $arg;
                    break;
            }
        }

        if (isset($reader)) {
            $this->data = call_user_func($reader, $this);
        } else if (is_file($this->source)) {
            $this->data = @file_get_contents($this->source);
        } else {
            throw new \UnexpectedValueException("{$this->source} is not a file or not readable.");
        }

        $this->prepare();
    }

    function getExtension()
    {
        return pathinfo($this->source, PATHINFO_EXTENSION);
    }

    /**
     * Called after the constructor
     */
    protected function prepare()
    {}

    function getData()
    {
        return $this->data;
    }

    function isFile()
    {
        return null !== $this->source and file_exists($this->source);
    }

    function getDirname()
    {
        if ($this->source) {
            return dirname($this->source);
        } else {
            return '';
        }
    }
}
