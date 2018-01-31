<?php

namespace Jedi\UserBundle\Utils;

use Jedi\UserBundle\Entity\User;

class SameDataEntered
{
    private $_encodePassword;

    public function __construct(EncodePassword $encodePassword)
    {
        $this->_encodePassword = $encodePassword;
    }


    public function checkForSameData(array $data, User $user)
    {
        if(
            $user->getEmail() === $data['email']
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