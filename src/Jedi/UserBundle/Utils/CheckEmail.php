<?php

/**
 * Check email service for checking if email exists in the db
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
namespace Jedi\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use Jedi\UserBundle\Entity\User;

/**
 * Class CheckEmail  Doc Comment
 *
 * @category CheckEmail
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class CheckEmail
{
    private $_em;

    /**
     * CheckEmail constructor.
     *
     * @param \Doctrine\ORM\EntityManager $em Entity Manager for running queires
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * Check if email exists while in the update profile page
     *
     * @param \Jedi\UserBundle\Entity\User $user  User object to check
     *                                            current user in the home page
     * @param string                       $email email to check
     *                                            if it already exists
     *
     * @return bool
     */
    public function checkEmailExistsInUpdate(User $user, $email)
    {
        $isExists = $this->_em->getRepository('UserBundle:User')
            ->findOneBy(['_email' => $email]);
        $isEqual = strcmp($email, $user->getEmail());
        if (0 !== $isEqual && $isExists) {
            return true;
        }
        return false;
    }

    /**
     * Check if email exists while in the register profile page
     *
     * @param string $email Check if email exists in the db.
     *
     * @return bool
     */
    public function checkEmailExistsInRegister($email)
    {
        $isExists = $this->_em->getRepository('UserBundle:User')
            ->findOneBy(['_email' => $email]);
        if ($isExists) {
            return true;
        }
        return false;
    }
}