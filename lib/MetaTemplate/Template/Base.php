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
    function __construct($source = null, $options = null, $reader = null)
    {
        foreach (array_filter(array($source, $reader, $options)) as $arg) {
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

        if (is_callable($reader)) {
            $this->data = call_user_func($reader, $this);

        } else if (file_exists($this->source) and is_readable($this->source)) {
            $this->data = @file_get_contents($this->source);
        }

        $this->prepare();
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
