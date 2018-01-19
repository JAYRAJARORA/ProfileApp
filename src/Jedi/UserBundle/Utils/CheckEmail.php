<?php



namespace Jedi\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use Jedi\UserBundle\Entity\User;

class CheckEmail
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function checkEmailExists(User $user, $email)
    {
        $isExists = $this->em->getRepository('UserBundle:User')->findOneBy(['email' => $email]);
        $isEqual = strcmp($email, $user->getEmail());
        if (0 !== $isEqual && $isExists) {
            return true;
        }
        return false;
    }
}