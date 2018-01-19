<?php

namespace Jedi\UserBundle\Utils;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Jedi\UserBundle\Entity\User;

class EncodePassword
{
    private $encoder;

    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoder = $encoderFactory;
    }

    /**
     * Encodes the password using bcrypt
     *
     * @param User $user
     * @param $plainpassword
     * @return string
     */
    public function encodePassword(User $user, $plainPassword)
    {
        $encoderPassword = $this->encoder->getEncoder($user);
        return $encoderPassword->encodePassword($plainPassword, $user->getSalt());
    }

}