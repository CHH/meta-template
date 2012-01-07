<?php

require_once __DIR__ . "/../vendor/.composer/autoload.php";

use Symfony\Component\ClassLoader\UniversalClassLoader;

$classLoader = new UniversalClassLoader;

$classLoader->registerNamespace('MetaTemplate', array(
    realpath(__DIR__ . '/../lib'),
    realpath(__DIR__)
));

if (isset($_ENV['MARKDOWN_LIB'])) {
    require $_ENV['MARKDOWN_LIB'].'/markdown.php';
}

$classLoader->register();
