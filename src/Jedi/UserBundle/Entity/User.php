<?php

/**
 * User Entity to make model of user
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  DataFixtures
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User Doc Comment
 *
 * @category UserEntity
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 *
 * @ORM\Table(name="jedi_user")
 * @ORM\Entity(repositoryClass="Jedi\UserBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields="_email",
 *     message="That email already exists"
 * )
 *
 * @UniqueEntity(fields="_username",message="That username already exists")
 * @UniqueEntity(fields="_forgotPassId")
 */
class User implements AdvancedUserInterface,\Serializable
{
    /**
     * Id property
     *
     * @var int
     *
     * @ORM\Column(
     *     name="id",
     *     type="integer"
     * )
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /**
     * User constructor.
     */
    public function __construct()
    {
    }


    /**
     * Forgot passowrd id property
     *
     * @var int
     *
     * @ORM\Column(name="forgot_pass_id", type="integer",
     *     options={"default": 0}, nullable=true)
     */
    private $_forgotPassId;

    /**
     * Token Time property
     *
     * @var \DateTime
     *
     * @ORM\Column(name="token_time", type="datetime", nullable=true)
     */
    private $_tokenTime;
    
    /**
     * Username property
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $_username;

    /**
     * Password property
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $_password;

    /**
     * Roles property
     *
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $_roles = array();

    /**
     * Is active user property
     *
     * @var bool
     *
     * @ORM\Column(name="is_active",type="boolean")
     */
    private $_isActive = true;


    /**
     * Just stores the data temporarily
     *
     * @var string
     */
    private $_plainPassword;


    /**
     * Firstname property
     *
     * @var string
     *
     * @ORM\Column(name="firstname",type="string",length=40)
     */
    private $_firstname;


    /**
     * Lastname property
     *
     * @var string
     *
     * @ORM\Column(name="lastname",type="string",length=40, nullable=true)
     */
    private $_lastname;

    /**
     * Address property
     *
     * @var string
     *
     * @ORM\Column(name="address", type="text",nullable=true)
     */
    private $_address;


    /**
     * Gender of user
     *
     * @var bool
     *
     * @ORM\Column(name="gender", type="string",
     *     length=20,options={"default": "male"})
     */
    private $_gender = "male";

    /**
     * Email id property
     *
     * @var
     *
     * @ORM\Column(name="email", type="string", length=255,unique=true)
     */
    private $_email;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set username
     *
     * @param string $username Set username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->_username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Set password
     *
     * @param string $password Set password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Retrieve roles
     *
     * @return array Roles array
     */
    public function getRoles()
    {
        $roles = $this->_roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the roles of user
     *
     * @param array $roles Roles array
     *
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->_roles = $roles;

        return $this;
    }

    /**
     * Set if the user is active
     *
     * @param bool $isActive If the user is active
     *
     * @return void
     */
    public function setIsActive($isActive)
    {
        $this->_isActive = $isActive;
    }

    /**
     * Retrieve if the user is active or not
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->_isActive;
    }

    /**
     * Get salt of user
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set the user credentials
     *
     * @return void
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * Expire the user's account
     *
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Lock the user account
     *
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Check if the user's credentials are valid
     *
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Check to see if the account is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_isActive;
    }

    /**
     * Set email
     *
     * @param string $email Email property
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
    /**
     * String reperesentation of the object
     *
     * @return string representation of the null or null
     */
    public function serialize()
    {
        return serialize(
            array(
                $this->_id,
                $this->_username,
                $this->_password
            )
        );
    }

    /**
     * Unserialize the object
     *
     * @param string $serialized Serialized object
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->_id,
            $this->_username,
            $this->_password
            ) = unserialize($serialized);
    }

    /**
     * Set Plain password
     *
     * @param string $plainPassword Password
     *
     * @return void
     */
    public function setPlainPassword($plainPassword)
    {
        $this->_plainPassword = $plainPassword;
    }

    /**
     * Retrieve plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->_plainPassword;
    }

    /**
     * String representation of the user object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }


    /**
     * Set forgot Password unique id
     *
     * @param integer $forgotPassId Forgot password id
     *
     * @return User
     */
    public function setForgotPassId($forgotPassId)
    {
        $this->_forgotPassId = $forgotPassId;

        return $this;
    }

    /**
     * Get forgot password id
     *
     * @return integer 
     */
    public function getForgotPassId()
    {
        return $this->_forgotPassId;
    }

    /**
     * Set token time
     *
     * @param \DateTime $tokenTime Token time for resetting password
     *
     * @return User
     */
    public function setTokenTime($tokenTime)
    {
        $this->_tokenTime = $tokenTime;
        return $this;
    }

    /**
     * Get token time
     *
     * @return \DateTime 
     */
    public function getTokenTime()
    {
        return $this->_tokenTime;
    }

    /**
     * Set firstname
     *
     * @param string $firstname Firstname of user
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname Lastname of user
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * Set address
     *
     * @param string $address Address of user
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->_address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Set gender
     *
     * @param boolean $gender Gender of user
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean 
     */
    public function getGender()
    {
        return $this->_gender;
    }
}
