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
    // SETUP -----------------------------------------------------------------
    // end - SETUP -----------------------------------------------------------

    // TESTS ------------------------------------------------------------------

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

    public function testConstructorSaveParameters()
    {
        $className = 'redfox\autoload\ClassLoader';
        $mock = $this->getMockBuilder($className)
                    ->disableOriginalConstructor()
                    ->getMock();

        $mock->expects($this->once())
            ->method('addNamespace')->with('name\space', 'dir/ectory');

        // now call the constructor
        $reflectedClass = new \ReflectionClass($className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, 'name\space', 'dir/ectory');
    }

    // end - TESTS ------------------------------------------------------------

    // DATA PROVIDER ----------------------------------------------------------
    // end - DATA PROVIDER ----------------------------------------------------
}