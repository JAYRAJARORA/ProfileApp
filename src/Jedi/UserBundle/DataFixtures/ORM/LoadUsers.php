<?php

/**
 * Data Fixtures to load dummy users
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
namespace Jedi\UserBundle\DataFixtures\ORM;

use Jedi\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class Load Users Doc Comment
 *
 * @category DataFixtures
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class LoadUsers implements FixtureInterface,
    ContainerAwareInterface,OrderedFixtureInterface
{
    /**
     * Get the container object  in the data fixtures class
     *
     * @var ContainerInterface
     */
    private $_container;

    /**
     * Load the new dummy users in the db
     *
     * @param ObjectManager $manager manager to persist the object to the dB.
     *
     * @return null
     */
    public function load(ObjectManager $manager)
    {
        $encode_object = $this->_container->get('password.encode');
        $user = new User();
        $user->setUsername('darth');
        $user->setFirstname('darth');
        $user->setLastname('wader');
        $user->setPassword($encode_object->encodePassword($user, 'darth'));
        $user->setEmail('darth@deathstar.com');
        $manager->persist($user);


        $admin = new User();
        $admin->setUsername('wayne');
        $admin->setFirstname('bruce');
        $admin->setLastname('wayne');
        $admin->setEmail('wayne@deahstar.com');
        $admin->setPassword($encode_object->encodePassword($admin, 'wayne'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);


        $manager->flush();

        return null;
    }

    /**
     * Allow usage of container services here
     *
     * @param ContainerInterface|null $container Set the Container object
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
         $this->_container = $container;
    }

    /**
     * Allow ordering of fixtures using ordered interface
     *
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }

}