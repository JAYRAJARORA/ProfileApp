<?php

/**
 * Register Form Validation
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  RegisterFormValidation
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
 * @category RegisterFormValidation
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class RegisterFormValidation
{
    /**
     * Validate Register form
     *
     * @param \Jedi\UserBundle\Entity\User $user User to validate
     *
     * @return array|string array of string in errors
     */
    public function validateRegisterForm(User $user)
    {
        $alphabet_regex = '/^[a-zA-Z][a-zA-Z ]*$/';
        $username = $user->getUsername();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $password = $user->getPlainPassword();
        $email = $user->getEmail();
        $errors = '';

        if ('' === $username) {
            $errors .= 'Invalid username' ;
        } else if ('' === $email  || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= 'Invalid email';
        } else if ($password == '') {
            $errors .= 'Invalid password';
        } else if ($firstname == '' || !preg_match($alphabet_regex, $firstname)) {
            $errors .= 'Invalid firstname';
        } else if ('' === $lastname || !preg_match($alphabet_regex, $lastname)) {
            $errors .= 'Invalid lastname';
        }

        return $errors;
    }
}