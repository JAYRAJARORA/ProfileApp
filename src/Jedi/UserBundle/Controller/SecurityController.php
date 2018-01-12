<?php

namespace Jedi\UserBundle\Controller;

use Jedi\UserBundle\Entity\User;
use Jedi\UserBundle\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * @Template
     * @Route("/login",name="login_form")
     */
    public function loginAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                return $this->redirect($this->generateUrl('home_page'));
        }
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $errors = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return  array(
            'last_username' => $lastUsername,
            'error'         => $errors,
        );
    }

    /**
     * @Route("/login_check",name="login_check")
     */
    public function loginCheckAction()
    {
        // nothing put here...
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {
        // nothing put here...
    }


}