<?php

/**
 * Update Form Validation
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  CheckEmail
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Utils\FormValidate;

/**
 * Class Update Doc Comment
 *
 * @category UpdateFormValidation
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class UpdateFormValidation
{
    /**
     * Validate Update form
     *
     * @param array $data Array containing user data
     *
     * @return array|string errors in the form
     */
    public function validateUpdateForm($data)
    {
        $firstname = htmlentities($data['firstname']);
        $lastname = htmlentities($data['lastname']);
        $email = htmlentities($data['email']);
        $errors = '';

        if ($firstname == '' || !preg_match('/^[a-zA-Z][a-zA-Z ]*$/', $firstname)) {
            $errors .= 'Invalid username' ;
        } else if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= 'Invalid email';
        } else if ($firstname == '') {
            $errors .= 'Invalid firstname';
        } else if ($lastname == ''
            || !preg_match('/^[a-zA-Z][a-zA-Z ]*$/', $lastname)
        ) {
            $errors .= 'Invalid lastname';
        }
        return $errors;
    }
}