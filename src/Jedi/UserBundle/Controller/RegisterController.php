<?php

/**
 * Register Controller containing the register and email check actions
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  HomePage
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Jedi\UserBundle\Form\RegisterFormType;

/**
 * Class Register Controller Doc Comment
 *
 * @category RegisterController
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class RegisterController extends Controller
{
    /**
     * Register the users
     *
     * @param Request $request to handle request data
     *
     * @return mixed register page view if the user is not authenticated
     * and url Redirect to home page if user is already logged in
     *
     * @Route("/register",name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        // redirect already registered users
        if ($this->container->get(
            'security.authorization_checker'
        )->isGranted(
            'IS_AUTHENTICATED_REMEMBERED'
        )
        ) {
            return $this->redirect($this->generateUrl('home_page'));
        }
        // register form
        $form = $this->createForm(RegisterFormType::class);

        // handles validation for the user object coming
        $form->handleRequest($request);
        $has_error = array();

        // if submitted as post and is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $has_error = $this->get(
                'validate.register'
            )
                ->validateRegisterForm($user);

            if (!$has_error) {
                $encode_object = $this->container->get('password.encode');
                $user->setPassword(
                    $encode_object->encodePassword(
                        $user,
                        $user->getPlainPassword()
                    )
                );
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // flashbag to show user only once
                $request->getSession()
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Successfully Registered.Kindly Login.'
                    );
                $url = $this->generateUrl('login_form');
                return $this->redirect($url);
            }
        }
        return array('form'=>$form->createView(), 'has_error' => $has_error);
    }


    /**
     * Helper action to check the email for checking if an email id already exists
     *
     * @param Request $request to handle data coming
     *
     * @return JsonResponse $response Response of error message if id exists
     * or else null for success response
     *
     * @Route("/register/check_email",name="checkRegisterEmail")
     */
    public function checkEmailAction(Request $request)
    {
        $email = ($this->get('request')->request->get('email'));
        $isExist = $this->container->get(
            'email.check'
        )->checkEmailExistsInRegister($email);

        if ($isExist) {
            $response = array('error' => 'Email id already exists');
        } else {
            $response = array('success' => 'Valid id');
        }
        $response = new JsonResponse($response);
        return $response;
    }


    /**
     * Helper action to check the username for checking if username already exists
     *
     * @param Request $request to handle data coming
     *
     * @return JsonResponse $response Response of error message if id exists
     * or else null for success response
     *
     * @Route("/register/check_username", name="checkRegisterUsername")
     */
    public function checkUsernameAction(Request $request)
    {
        $username = ($this->get('request')->request->get('username'));
        $isExist = $this->container->get(
            'username.check'
        )->checkUsername($username);

        if ($isExist) {
            $response = array('error' => 'Username already exists');
        } else {
            $response = array('success' => 'Valid id');
        }
        $response = new JsonResponse($response);
        return $response;
    }
}