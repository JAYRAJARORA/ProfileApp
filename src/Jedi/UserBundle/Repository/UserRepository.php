<?php

/**
 * Entity Repository to write custom queries
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  Repository
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */
namespace Jedi\UserBundle\Repository;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Jedi\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository Doc Comment
 *
 * @category UserRepository
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Allow login to be done via username or email
     *
     * @param string $username Username or email to fetch the user for login
     *
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByEmailOrUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u._username = :username OR u._email= :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)->getQuery()
            ->getOneOrNullResult();
    }



    /**
     * Symfony security is sent here to check the username or email
     *
     * @param string $username Username of the user trying to log in
     *
     * @return User|null|UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        $user = $this->findOneByEmailOrUsername($username);
        return $user;
    }

    /**
     * Support functions which comes in UserProvider Interface
     *
     * @param UserInterface $user user that comes from the dB
     *
     * @return null|object
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        if (!$refreshedUser = $this->find($user->getId())) {
            throw new UsernameNotFoundException(
                sprintf(
                    'User with id %s not found',
                    json_encode($user->getId())
                )
            );
        }
        return $refreshedUser;
    }

    /**
     * Suppport Function for the user provider provider interface
     *
     * @param string $class Class of the user
     *
     * @return bool Boolean value which checks the entity name
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
}
