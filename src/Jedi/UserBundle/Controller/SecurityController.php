<?php

/**
 * Security Controller containing the security actions, reset Password
 * and send email actions
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

use Jedi\UserBundle\Entity\User;
use Jedi\UserBundle\Form\ResetPasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Security Controller Doc Comment
 *
 * @category SecurityController
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class SecurityController extends Controller
{
    /**
     * Login form for already registered users which submits to loginCheck Action
     *
     * @param Request $request To handle incoming data
     *
     * @return mixed Home page if user is already logged in else
     * show the login page for unauthenticated users.
     *
     * @Template
     * @Route("/login",name="login_form")
     */
    public function loginAction(Request $request)
    {
        // Redirect to home page for already authenticated users
        if ($this->container->get(
            'security.authorization_checker'
        )->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
                return $this->redirect($this->generateUrl('home_page'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $errors = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return  array(
            'last_username' => $lastUsername,
            'error'         => $errors
        );
    }

    /**
     * Login form submitted to the login check but
     * symfony intercepts to check if user exists in the dB
     * and return to the login page with appropriate errors or logs in the user
     *
     * @return null
     *
     * @Route("/login_check",name="login_check")
     */
    public function loginCheckAction()
    {
        // handled by the symfony to check the username and password in the db
    }

    /**
     * Logout action which is handled by the symfony using security.yml
     *
     * @return null
     *
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {
        // Logout handled by the symfony security.yml
    }

    /**
     * Send email to the user's email id to reset the password
     *
     * @param Request $request To handle incoming data
     *
     * @return JsonResponse $response Send the appropriate
     * message if message is sent or not
     *
     * @Route("/send_email",name="send_email")
     */
    public function sendEmailAction(Request $request)
    {
        $email = ($this->get('request')->request->get('email'));
        $data = $this->get('email.send')->sendEmail($email);
        $response = new JsonResponse($data);
        return $response;
    }

    /**
     * Reset Action to reset the password if user forgets the password
     * and link is expired in 1 hr.
     *
     * @param integer $forgot_pass_id unique token to check
     *                                which user wants to reset the password
     * @param Request $request        To handle the incoming data
     *
     * @return mixed Url redirect if user successfully update
     * the password or the link is expired or an Exception if the page is not found
     *
     * @Route("/reset/{forgot_pass_id}",name="reset_password")
     * @Template
     */
    public function resetAction($forgot_pass_id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $user = $repo->findOneBy(
            array(
            '_forgot_pass_id' => $forgot_pass_id
            )
        );
        if ($user) {
            $epoch = time();
            $current_time = date(
                'Y-m-d H:i:s',
                $epoch
            );
            $submit_time = ($user->getTokenTime());
            $submit_time = $submit_time->format('Y-m-d H:i:s');
            $difference_in_seconds = strtotime(
                $current_time
            ) - strtotime($submit_time);
            if (($difference_in_seconds / 3600) > 1) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('warning', 'Link Expired.Kindly reset the password again');

                return $this->redirect($this->generateUrl('login_form'));
            } else {
                $form = $this->createForm(new ResetPasswordFormType());
                $form->handleRequest($request);
                $has_error = array();

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $has_error = $this->get('validate.reset')
                        ->validateResetForm($data);

                    if (!$has_error) {
                        $encode_object = $this->container->get('password.encode');
                        $user->setPassword(
                            $encode_object->encodePassword(
                                $user, $data['plainPassword']
                            )
                        );
                        $em->persist($user);
                        $em->flush();

                        // Flashbag to show user success response only once
                        $request->getSession()
                            ->getFlashBag()
                            ->add('success', 'Password Reset Successfully.');
                        $url = $this->generateUrl('login_form');
                        return $this->redirect($url);
                    }
                }

                return array('form'=>$form->createView(),
                    'forgot_pass_id' => $forgot_pass_id,
                    'user' => $user, 'has_error' => $has_error);
            }
        } else {
            throw new NotFoundHttpException("Page not found");
        }
    }
}