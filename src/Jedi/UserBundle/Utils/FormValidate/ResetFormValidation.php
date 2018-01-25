<?php

/**
 * Reset Form Validation
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  ResetPasswordValidation
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Utils\FormValidate;

use Jedi\UserBundle\Entity\User;

/**
 * Class Register  Doc Comment
 *
 * @category ResetFormValidation
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class ResetFormValidation
{
    /**
     * Validate Reset form
     *
     * @param string $data Data containing plaiinPassword
     *
     * @return array|string array of string in errors
     */
    public function validateResetForm($data)
    {
        $password = htmlentities($data['plainPassword']);
        $errors = '';

        if ($password == '') {
            $errors .= 'Invalid password';
        }

        return $errors;
    }
}