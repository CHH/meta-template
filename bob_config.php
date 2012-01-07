<?php
/*
 * Put the `bob_config.php` into the "Bob" namespace,
 * otherwise you would've to call the `task` and
 * `desc` functions with a `Bob\` prefix.
 */
namespace Bob;

task('default', array('test'));

desc("Runs all tests");
task('test', array('composer.lock'), function() {
    if (!file_exists('phpunit.xml')) {
        copy('phpunit.dist.xml', 'phpunit.xml');
    }

    echo sh('phpunit');
});

desc('Runs "composer update" when the composer.json was changed');
fileTask('composer.lock', array('composer.json'), function($task) {
    echo sh('composer update');
});
