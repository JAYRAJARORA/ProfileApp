<?php

namespace Jedi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * Login form for already registered users
     *
     * @Template
     * @Route("/login",name="login_form")
     */
    public function loginAction(Request $request)
    {
        /** Redirect to home page for already authenticated users */
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
     *
     * @Route("/login_check",name="login_check")
     */
    public function loginCheckAction()
    {
        /** handled by the symfony to check the username and password in the db */
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {
        /** Logout handled by the symfony security.yml */
    }
}