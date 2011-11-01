<?php

namespace MetaTemplate\Test\Util;

use MetaTemplate\Util\LoadPath;

class LoadPathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    function testThrowsExceptionIfDirNotFound()
    {
        $loadPath = new LoadPath;
        $loadPath->push('/some/directory/which/doesnt/exist');
    }

    function testConvertsToColonSeparatedString()
    {
        $loadPath = new LoadPath(array(
            __DIR__, __DIR__.'/../fixtures'
        ));

        $this->assertEquals(
            __DIR__.'/../fixtures'.':'.__DIR__,
            (string) $loadPath
        );
    }

    function testTrimsDirectorySeparatorsFromEnd()
    {
        $loadPath = new LoadPath;
        $loadPath->push(__DIR__.'/');

        $this->assertEquals(__DIR__, (string) $loadPath);
    }

    function testFindsFileInLoadPath()
    {
        $loadPath = new LoadPath;
        $loadPath->pushAll(array(
            __DIR__.'/fixtures/path1',
            __DIR__.'/fixtures/path2'
        ));

        $file = $loadPath->find('file1.txt');

        $this->assertEquals(__DIR__.'/fixtures/path2/file1.txt', $file);
    }

    function testReturnsFalseIfNotFoundInLoadPath()
    {
        $loadPath = new LoadPath;
        $loadPath->push(__DIR__.'/fixtures/path1');

        $this->assertFalse($loadPath->find('foo.txt'));
    }
}
