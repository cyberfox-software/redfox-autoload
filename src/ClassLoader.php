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
 * ----------------------------------------------------------------------------
 */

namespace Redfox\Autoload;

/**
 * Class ClassLoader
 *
 * @package redfox\autoload
 * @author Christian Graf <christian.graf@cyberfox.at>
 */
class ClassLoader implements ClassLoaderInterface
{
    // TRAITS -----------------------------------------------------------------
    // end - TRAITS -----------------------------------------------------------

    // CONSTANTS & FIELDS -----------------------------------------------------

    const NAMESPACE_SEPARATOR = '\\';

    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    protected $namespaceList = [];

    // end - CONSTANTS & FIELDS -----------------------------------------------

    // PROPERTIES -------------------------------------------------------------
    // end - PROPERTIES -------------------------------------------------------

    // CONSTRUCTOR ------------------------------------------------------------

    /**
     * ClassLoader constructor.
     *
     * @param string|null $namespacePrefix
     * @param string|null $baseDirectory
     * @param bool $prepend
     */
    public function __construct(
        string $namespacePrefix = null,
        string $baseDirectory = null,
        bool $prepend = false
    ) {
        if (!empty($namespacePrefix) && !empty($baseDirectory))
        {
            $this->addNamespace($namespacePrefix, $baseDirectory, $prepend);
        }
    }

    // end - CONSTRUCTOR ------------------------------------------------------

    // IMPLEMENT - ClassLoaderInterface ---------------------------------------

    /**
     * @inheritdoc
     */
    public function register()
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * @inheritdoc
     */
    public function unRegister()
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * @inheritdoc
     */
    public function load($className)
    {
        $namespace = trim($className);
        if (empty($namespace))
        {
            return false;
        }

        // work backwards through the namespace names of the fully-qualified
        // class name to find a mapped file name
        while (($pos = strrpos($namespace, self::NAMESPACE_SEPARATOR)) !== false)
        {
            // retain the trailing namespace separator in the prefix
            $namespace = substr($className, 0, $pos + 1);

            // the rest is the relative class name
            $relativeClass = substr($className, $pos + 1);

            // try to load a mapped file for the prefix and relative class
            $mappedFile = $this->loadMappedFile($namespace, $relativeClass);
            if ($mappedFile)
            {
                return $mappedFile;
            }

            // remove the trailing namespace separator for the next iteration of strrpos()
            $namespace = rtrim($namespace, self::NAMESPACE_SEPARATOR);
        }

        // never found mapped file
        return false;
    }

    // end - IMPLEMENT - ClassLoaderInterface ---------------------------------

    // MEMBERS ----------------------------------------------------------------

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $namespacePrefix The namespace prefix.
     * @param string $baseDirectory The base directory for the class files within the namespace.
     * @param bool $prepend If true, prepend the base directory to the stack instead of appending it;
     * this causes it to be searched first rather than last.
     *
     * @return void
     */
    public function addNamespace(string $namespacePrefix, string $baseDirectory, bool $prepend = false)
    {
        // normalize namespace prefix
        $namespacePrefix = trim(
                str_replace(['/', '\\'], self::NAMESPACE_SEPARATOR, trim($namespacePrefix)),
                self::NAMESPACE_SEPARATOR
            ) . self::NAMESPACE_SEPARATOR;

        // normalize the base directory with a trailing separator
        $baseDirectory = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, trim($baseDirectory));
        $baseDirectory = rtrim($baseDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // initialize the namespace prefix array
        if (isset($this->namespaceList[$namespacePrefix]) === false)
        {
            $this->namespaceList[$namespacePrefix] = [];
        }

        // retain the base directory for the namespace prefix
        if ($prepend)
        {
            array_unshift($this->namespaceList[$namespacePrefix], $baseDirectory);
        }
        else
        {
            array_push($this->namespaceList[$namespacePrefix], $baseDirectory);
        }
    }

    // end - MEMBERS ----------------------------------------------------------

    // HELPER -----------------------------------------------------------------

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $namespace The namespace prefix.
     * @param string $relativeClass The relative class name.
     *
     * @return string the name of the mapped file that was loaded.
     */
    protected function loadMappedFile($namespace, $relativeClass)
    {
        // are there any base directories for this namespace prefix?
        if (isset($this->namespaceList[$namespace]) === false)
        {
            return false;
        }

        //look through base directories for this namespace prefix
        foreach ($this->namespaceList[$namespace] as $baseDir)
        {
            // replace the namespace prefix with the base directory,
            // replace namespace separators with directory separators
            // in the relative class name, append with .php
            $file = $baseDir
                . str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $relativeClass)
                . '.php';

            // if the mapped file exists, require it
            if ($this->requireFile($file))
            {
                // yes, we're done here
                return $file;
            }
        }

        // never found it
        return false;
    }

    /**
     * If a file exists, require it from the file system and return true.
     *
     * @param string $file The file to require.
     *
     * @return bool True if the file exists, false if not.
     */
    protected function requireFile($file)
    {
        if (file_exists($file))
        {
            /** @noinspection PhpIncludeInspection */
            require_once $file;

            return true;
        }

        return false;
    }

    // end - HELPER -----------------------------------------------------------
}
