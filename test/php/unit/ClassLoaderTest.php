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

namespace redfox\autoload\test\unit;

use redfox\autoload\ClassLoader;

/**
 * Class ClassLoaderTest
 *
 * @package redfox\autoload\test\unit
 * @author Christian Graf <christian.graf@cyberfox.at>
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $className = 'redfox\autoload\ClassLoader';

    // SETUP -----------------------------------------------------------------
    // end - SETUP -----------------------------------------------------------

    // TESTS ------------------------------------------------------------------

    /**
     * Test 1
     */
    public function testInstanceOfClassLoaderInterface()
    {
        $autoloader = new ClassLoader(
            'foo\bar',
            __DIR__ .DIRECTORY_SEPARATOR .'fooBar'
        );

        $this->assertInstanceOf(
            'redfox\autoload\ClassLoaderInterface',
            $autoloader
        );
    }

    /**
     * Test 2
     */
    public function testConstructorSaveParameters()
    {
        $mock = $this->getMockBuilder($this->className)
                    ->disableOriginalConstructor()
                    ->getMock();

        $mock->expects($this->once())
            ->method('addNamespace')->with('name\space', 'dir/ectory');

        // now call the constructor
        $reflectedClass = new \ReflectionClass($this->className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, 'name\space', 'dir/ectory');
    }

    /**
     * Test 3
     */
    public function testConstructorWithEmptyParameters()
    {
        $mock = $this->getMockBuilder($this->className)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->never())
            ->method('addNamespace');

        // now call the constructor
        $reflectedClass = new \ReflectionClass($this->className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
        $constructor->invoke($mock, 'name\space');
        $constructor->invoke($mock, null, 'dir/ectory');
    }

    /**
     * Test 4
     */
    /* public function testAddNamespaceSavingParameters()
    {
        $className = 'redfox\autoload\ClassLoader';
        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }*/


    // end - TESTS ------------------------------------------------------------

    // DATA PROVIDER ----------------------------------------------------------
    // end - DATA PROVIDER ----------------------------------------------------
}