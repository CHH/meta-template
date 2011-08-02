<?php

require_once __DIR__ . "/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php";

use Symfony\Component\ClassLoader\UniversalClassLoader;

$classLoader = new UniversalClassLoader;
$classLoader->registerNamespace('Symfony', realpath(__DIR__ . "/../vendor/Symfony"));

$classLoader->register();
