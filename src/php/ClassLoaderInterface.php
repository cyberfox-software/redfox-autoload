<?php
declare(strict_types=1);
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

namespace Redfox\Autoload;

/**
 * Interface ClassLoaderInterface
 *
 * @package redfox\autoload
 * @author Christian Graf <christian.graf@cyberfox.at>
 */
interface ClassLoaderInterface
{
    /**
     * Register the autoloader to the SPL autoloader stack.
     *
     * @return void
     */
    public function register();

    /**
     * Un-register the autoloader from the SPL autoloader stack.
     *
     * @return void
     */
    public function unRegister();

    /**
     * Loads the class file for a given class name.
     *
     * @param string $className The fully-qualified class name.
     * @return string|false The mapped file name on success, or boolean false on failure.
     */
    public function load(string $className);
}
