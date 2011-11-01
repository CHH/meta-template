<?php

require_once __DIR__ . "/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php";

use Symfony\Component\ClassLoader\UniversalClassLoader;

$classLoader = new UniversalClassLoader;

$classLoader->registerNamespace('Symfony', realpath(__DIR__ . "/../vendor/"));

$classLoader->registerNamespace('MetaTemplate', array(
    realpath(__DIR__ . '/../lib'),
    realpath(__DIR__)
));

if (isset($_ENV['MARKDOWN_LIB'])) {
    require $_ENV['MARKDOWN_LIB'].'/markdown.php';
}

if (isset($_ENV['MUSTACHE_LIB'])) {
    require $_ENV['MUSTACHE_LIB'].'/library/Phly/Mustache/_autoload.php';
}

$classLoader->register();
