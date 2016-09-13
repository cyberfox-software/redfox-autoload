<?php
/**
 * ----------------------------------------------------------------------------
 * This file is part of the "Redfox PHP Framework" and is subject to the
 * provisions of your License Agreement with Cyberfox Software Solutions e.U.
 *
 * @copyright (c) 2016 Cyberfox Software Solutions e.U.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redfox\Autoload\UnitTest;

use Redfox\Autoload\ClassLoader;

/**
 * Class ClassLoaderTest
 *
 * @package Redfox\Autoload\Test\Unit
 * @author Christian Graf <christian.graf@sclable.com>
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $className = 'Redfox\Autoload\ClassLoader';

    /**
     * @var null|ClassLoader|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $mock = null;

    // SETUP -----------------------------------------------------------------

    public function setUp()
    {
        $this->mock = $this->getMockBuilder($this->className)
            ->disableOriginalConstructor()
            ->getMock();
    }

    // end - SETUP -----------------------------------------------------------

    // TESTS ------------------------------------------------------------------

    /**
     * Test 1
     */
    public function testInstanceOfClassLoaderInterface()
    {
        $loader = new ClassLoader(
            'foo\bar',
            __DIR__ . '/fooBar'
        );

        $this->assertInstanceOf(
            $this->className,
            $loader
        );
    }

    /**
     * Test 2
     */
    public function testConstructorSaveParameters()
    {
        $this->mock->expects($this->once())
            ->method('addNamespace')->with('name\space', 'dir/ectory');

        // now call the constructor
        $reflectedClass = new \ReflectionClass($this->className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($this->mock, 'name\space', 'dir/ectory');
    }

    /**
     * Test 3
     */
    public function testConstructorWithEmptyParameters()
    {
        $this->mock->expects($this->never())
            ->method('addNamespace');

        // now call the constructor
        $reflectedClass = new \ReflectionClass($this->className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($this->mock);
        $constructor->invoke($this->mock, 'name\space', null);
        $constructor->invoke($this->mock, null, 'dir/ectory');
    }

    /**
     * Test 4
     */
    public function testAddNamespace()
    {
        $namespace = 'a\name\space\\' . str_shuffle('aAbBcCdDefghijklmnOPQ') . '\\';
        $directory = 'my' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . str_shuffle(
                'sub_directory'
            ) . DIRECTORY_SEPARATOR;
        $expected = [
            $namespace => [$directory]
        ];

        $reflectedClass = new \ReflectionMethod($this->className, 'addNamespace');
        $reflectedClass->setAccessible(true);

        $classLoader = new ClassLoader();
        $reflectedClass->invoke($classLoader, $namespace, $directory);

        $this->mock->addNamespace($namespace, $directory);
        $this->assertAttributeEquals(
            $expected,
            'namespaceList',
            $classLoader
        );
    }

    /**
     * Test 5
     */
    public function testAddNamespaceNormalizeNamespace()
    {
        $namespace = '\a/name\space';
        $directory = 'directory' . DIRECTORY_SEPARATOR;
        $expected = [
            'a\name\space\\' => [
                $directory
            ]
        ];

        $reflectedClass = new \ReflectionMethod($this->className, 'addNamespace');
        $reflectedClass->setAccessible(true);

        $classLoader = new ClassLoader();
        $reflectedClass->invoke($classLoader, $namespace, $directory);

        $this->mock->addNamespace($namespace, $directory);
        $this->assertAttributeEquals(
            $expected,
            'namespaceList',
            $classLoader
        );
    }

    /**
     * Test 6
     */
    public function testAddNamespaceNormalizeDirectory()
    {
        $namespace = 'my\name\space\\';
        $directory = '\my/directory\Test';
        $expected = [
            $namespace => [
                DIRECTORY_SEPARATOR . 'my' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'Test' . DIRECTORY_SEPARATOR
            ]
        ];

        $reflectedClass = new \ReflectionMethod($this->className, 'addNamespace');
        $reflectedClass->setAccessible(true);

        $classLoader = new ClassLoader();
        $reflectedClass->invoke($classLoader, $namespace, $directory);

        $this->mock->addNamespace($namespace, $directory);
        $this->assertAttributeEquals(
            $expected,
            'namespaceList',
            $classLoader
        );
    }


    // end - TESTS ------------------------------------------------------------

    // DATA PROVIDER ----------------------------------------------------------
    // end - DATA PROVIDER ----------------------------------------------------
}
