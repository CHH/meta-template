<?php

namespace MetaTemplate\Template;

class Base
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
     * @param string $reader Callback which returns the template's 
     *   contents or the template's file name
     * @param array  $options  Engine Options
     */
    function __construct($reader, $options = array())
    {
        $this->options = $options;

        if (is_callable($reader)) {
            $this->data = call_user_func($reader, $this);

        } else if (file_exists($reader) and is_readable($reader)) {
            $this->source = $reader;
            $this->data = @file_get_contents($reader);
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
}
