<?php

/**
 * Encodes the password using bcrypt
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  EncodePassword
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */
namespace Jedi\UserBundle\Utils;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Jedi\UserBundle\Entity\User;

/**
 * Class EncodePassword  Doc Comment
 *
 * @category EncodePassword
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class EncodePassword
{
    private $encoder;

    /**
     * EncodePassword constructor.
     *
     * @param EncoderFactory $encoderFactory Encoder factory for encoding password
     */
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoder = $encoderFactory;
    }

    /**
     * Encodes the password using bcrypt
     *
     * @param User   $user          Object to get salt for bcryting the password
     * @param string $plainPassword The password to be encoded
     *
     * @return string
     */
    public function encodePassword(User $user, $plainPassword)
    {
        $encoderPassword = $this->encoder->getEncoder($user);
        return $encoderPassword->encodePassword($plainPassword, $user->getSalt());
    }

}