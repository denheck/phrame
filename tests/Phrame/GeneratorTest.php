<?php

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $testDir = dirname(__DIR__);
        $this->fixtureDir = $testDir . DIRECTORY_SEPARATOR . 'fixtures';
        $this->tmpDir = $testDir . DIRECTORY_SEPARATOR . 'tmp';
    }

    public function testCopy()
    {
        $generator = $this->getMockBuilder('Phrame\Generator')
                          ->setMethods(array('getDestination', 'getSource'))
                          ->getMockForAbstractClass();

        $generator->expects($this->any())
                  ->method('getDestination')
                  ->will($this->returnValue($this->tmpDir));

        $generator->expects($this->any())
                  ->method('getSource')
                  ->will($this->returnValue($this->fixtureDir));

        $generator->copy('test.js.tmp', 'test.js');

        $this->assertFileExists($this->tmpDir . DIRECTORY_SEPARATOR . 'test.js');
    }

    public function tearDown()
    {
        unlink($this->tmpDir . DIRECTORY_SEPARATOR . 'test.js');
    }
}
