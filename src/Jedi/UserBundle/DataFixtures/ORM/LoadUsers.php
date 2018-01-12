<?php
namespace Jedi\UserBundle\DataFixtures\ORM;

use Jedi\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUsers implements FixtureInterface,ContainerAwareInterface,OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load the new dummy users in the db
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('darth');
        $user->setPassword($this->encodePassword($user, 'dathpass'));
        $user->setEmail('darth@deathstar.com');
        $manager->persist($user);


        $admin = new User();
        $admin->setUsername('wayne');
        $admin->setEmail('wayne@deahstar.com');
        $admin->setPassword($this->encodePassword($admin, 'waynepass'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);


        $manager->flush();
    }

    /**
     * Encodes the password using bcrypt
     *
     * @param User $user
     * @param $plainpassword
     * @return string
     */
    private function encodePassword(User $user, $plainpassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainpassword, $user->getSalt());
    }

    /**
     * Allow usage of container services here
     *
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
         $this->container = $container;
    }

    /**
     * allow ordering of fixtures using ordered interface
     *
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }

}