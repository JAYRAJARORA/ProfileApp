<?php
/**
 * Check username service for checking if email exists in the db
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  CheckUsername
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Utils;

use Doctrine\ORM\EntityManager;

/**
 * Class CheckUsername  Doc Comment
 *
 * @category CheckUsername
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class CheckUsername
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
     * Check if username exists while in the register profile page
     *
     * @param string $username Check if username exists in the db.
     *
     * @return bool
     */
    public function checkUsername($username)
    {
        $isExists = $this->_em->getRepository('UserBundle:User')
            ->findOneBy(['_username' => $username]);
        if ($isExists) {
            return true;
        }
        return false;
    }

}