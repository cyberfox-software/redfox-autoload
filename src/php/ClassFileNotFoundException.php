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

namespace redfox\autoload;

use \Exception;

/**
 * Class ClassFileNotFoundException
 *
 * @package redfox\autoload
 * @author Christian Graf <christian.graf@cyberfox.at>
 */
class ClassFileNotFoundException extends \Exception
{
    // TRAITS -----------------------------------------------------------------
    // end - TRAITS -----------------------------------------------------------

    // CONSTANTS & FIELDS -----------------------------------------------------
    // end - CONSTANTS & FIELDS -----------------------------------------------

    // PROPERTIES -------------------------------------------------------------
    // end - PROPERTIES -------------------------------------------------------

    // CONSTRUCTOR ------------------------------------------------------------

    /**
     * ClassFileNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(
        string $message = 'The designated class file could not be found',
        int $code = 0,
        \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // end - CONSTRUCTOR ------------------------------------------------------

    // MEMBERS ----------------------------------------------------------------
    // end - MEMBERS ----------------------------------------------------------
}
