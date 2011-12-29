<?php
/*
 * Put the `bob_config.php` into the "Bob" namespace,
 * otherwise you would've to call the `task` and
 * `desc` functions with a `Bob\` prefix.
 */
namespace Bob;

// Your package's name. Used to identify it on Packagist.org
function getName()
{
    return 'chh/meta-template';
}

// Should return the package's version.
//
// An idea would be to fetch the latest tag from the repo 
// in your favourite VCS.
function getVersion()
{
}

// Should return an array of authors.
// Each individual author should be an array of `name`, 
// `email` and optionally a `homepage`
//
// By default this parses an `AUTHORS.txt` file in the root
// of the project which is formatted with an author name on
// each line. For example:
//
//     Christoph Hochstrasser <christoph.hochstrasser@gmail.com>
//     John Doe <john@example.com>
//
function getAuthors()
{
    $authorsFile = 'AUTHORS.txt';

    if (!file_exists($authorsFile)) {
        return array();
    }

    $authors = array();

    foreach (new \SplFileObject($authorsFile) as $line) {
        if (preg_match('/^(.+) <(.+)>$/', $line, $matches)) {
            $authors[] = array(
                'name' => $matches[1],
                'email' => $matches[2]
            );
        }
    }

    return $authors;
}

// Note: All file paths used here should be relative to the project
// directory. Bob automatically sets the current working directory
// to the path where the `bob_config.php` resides.

// The first defined task is the default task for the case
// Bob is executed without a task name.
desc('Makes a distributable version of Bob, consisting of a composer.json 
      and a PHAR file.');
task('dist', array('composer.json'));

desc('Generates the composer.json from the composer_spec.php');
task('composer.json', array('composer_spec.php'), function($task) {
    $NAME = getName();
    $AUTHORS = getAuthors();
    $VERSION = getVersion();

    $pkg = include($task->prerequisites[0]);

    if (!is_array($pkg)) {
        println('Error: composer_spec.php MUST return an array');
        exit(1);
    }

    $jsonOptions = 0;

    if (defined('JSON_PRETTY_PRINT')) {
        $jsonOptions |= JSON_PRETTY_PRINT;
    }

    if (defined("JSON_UNESCAPED_SLASHES")) {
        $jsonOptions |= JSON_UNESCAPED_SLASHES;
    }

    $json = json_encode($pkg, $jsonOptions);

    println('Writing composer.json');
    @file_put_contents($task->name, $json);
});
