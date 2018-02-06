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

namespace Jedi\UserBundle\Utils;

use Jedi\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class FormValidation  Doc Comment
 *
 * @category FormValidation
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class Validation
{
    private $em;

    /**
     * Validations constructor.
     * @param \Doctrine\ORM\EntityManager $em Entity Manager for running queires
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Validate Register Form
     * @param \Jedi\UserBundle\Entity\User $user User to validate
     * @return array|string array of string in errors
     */
    public function validateRegisterForm(User $user)
    {
        $alphabet_regex = '/^[a-zA-Z][a-zA-Z ]*$/';
        $username = htmlentities($user->getUsername());
        $firstname = htmlentities($user->getFirstname());
        $lastname = htmlentities($user->getLastname());
        $password = htmlentities($user->getPlainPassword());
        $email = htmlentities($user->getEmail());
        $errors = '';

        if ('' === $username) {
            $errors .= 'Invalid username' ;
        } elseif ('' === $email  || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= 'Invalid email';
        } elseif ($password == '') {
            $errors .= 'Invalid password';
        } elseif ($firstname == '' || !preg_match($alphabet_regex, $firstname)) {
            $errors .= 'Invalid firstname';
        } elseif ('' === $lastname || !preg_match($alphabet_regex, $lastname)) {
            $errors .= 'Invalid lastname';
        }

        return $errors;
    }

    /**
     * Validate Update form
     * @param array $data Array containing user data
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
        } elseif ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= 'Invalid email';
        } elseif ($firstname == '') {
            $errors .= 'Invalid firstname';
        } elseif ($lastname == ''
            || !preg_match('/^[a-zA-Z][a-zA-Z ]*$/', $lastname)
        ) {
            $errors .= 'Invalid lastname';
        }
        return $errors;
    }

    /**
     * Validate Reset form
     * @param string $data Data containing plaiinPassword
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

    /**
     * Check if email exists while in the update profile page
     * @param \Jedi\UserBundle\Entity\User $user  User object to check
     *                                            current user in the home page
     * @param string                       $email email to check
     *                                            if it already exists
     * @return bool
     */
    public function checkEmailExistsInUpdate(User $user, $email)
    {
        $isExists = $this->em->getRepository('UserBundle:User')
            ->findOneBy(['_email' => $email]);
        $isEqual = strcmp($email, $user->getEmail());
        if (0 !== $isEqual && $isExists) {
            return true;
        }
        return false;
    }

    /**
     * Check if email exists while in the register profile page
     * @param string $email Check if email exists in the db.
     * @return bool
     */
    public function checkEmailExistsInRegister($email)
    {
        $isExists = $this->em->getRepository('UserBundle:User')
            ->findOneBy(['_email' => $email]);
        if ($isExists) {
            return true;
        }
        return false;
    }

    /**
     * Check if username exists while in the register profile page
     * @param string $username Check if username exists in the db.
     * @return bool
     */
    public function checkUsername($username)
    {
        $isExists = $this->em->getRepository('UserBundle:User')
            ->findOneBy(['_username' => $username]);
        if ($isExists) {
            return true;
        }
        return false;
    }

    /**
     * Check if same data is entered in the update profile page
     * @param array $data
     * @param User $user
     * @return bool
     */
    public function checkForSameData(array $data, User $user)
    {
        if ($user->getEmail() === $data['email']
            && $user->getAddress() === $data['address']
            && $user->getLastname() === $data['lastname']
            && $user->getFirstname() === $data['firstname']
            && $user->getGender() === $data['gender']
        ) {
            if ('' == $data['plainPassword']) {
                return true;
            }
        }
        return false;
    }
}
