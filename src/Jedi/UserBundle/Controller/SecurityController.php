<?php

namespace Jedi\UserBundle\Controller;

use Jedi\UserBundle\Entity\User;
use Jedi\UserBundle\Form\ResetPasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
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

    /**
     * @Route("/send_email",name="send_email")
     *
     *
     * @param
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendEmailAction()
    {
        $email = ($this->get('request')->request->get('email'));
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('UserBundle:User');
        $result = $repo->findOneByEmailOrUsername($email);
        if ($result) {
            $rand_num = mt_rand();
            $result->setForgotPassId($rand_num);
            $epoch = time();
            $current_time = date(
                'Y-m-d H:i:s',
                $epoch
            );
            $date = new DateTime($current_time);
            $result->setTokenTime($date);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('jayraj.arora@gmail.com')
                ->setTo('jkarora2612@gmail.com')
                ->setBody(
                    $this->renderView(
                        '@User/Security/sendemail.html.twig',
                        array(
                            'forgot_pass_id' => $rand_num
                        )
                    ),
                    'text/html'
                );

            $status= $this->get('mailer')->send($message);
            if (1 === $status) {
                $data = array(
                    'success' => 'Reset link sent successfully'
                );

            } else {
                $data = array(
                    'error' => 'Unable to send data'
                );
            }
        } else {
            $data = array(
                'error' => 'Sorry,email doesn\'t exists'
            );
        }
        $response = new JsonResponse($data);
        return $response;
    }

    /**
     * @Route("/reset/{forgot_pass_id}",name="reset_password")
     * @Template
     */
    public function resetAction($forgot_pass_id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $user = $repo->findOneBy(array(
            'forgot_pass_id' => $forgot_pass_id
        ));
        if ($user) {
            $epoch = time();
            $current_time = date(
                'Y-m-d H:i:s',
                $epoch
            );
            $submit_time = ($user->getTokenTime());
            $submit_time = $submit_time->format('Y-m-d H:i:s');
            $difference_in_seconds = strtotime($current_time) - strtotime($submit_time);
            if (($difference_in_seconds / 3600) > 1) {
                return $this->render(
                    'UserBundle:Security:expired.html.twig'
                );
            } else {
                $form = $this->createForm(new ResetPasswordFormType());
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $password = $form->getData();
                    $encode_object = $this->container->get('encode_password');
                    $user->setPassword($encode_object->encodePassword($user, $user->getPlainPassword()));
                    $em->persist($user);
                    $em->flush();
                    /** flashbag to show user only once */
                    $request->getSession()->getFlashBag()->add('success', 'Password Reset Successfully.');
                    $url = $this->generateUrl('login_form');
                    return $this->redirect($url);


                }
                return array('form'=>$form->createView(),
                    'forgot_pass_id' => $forgot_pass_id);
            }
        } else {
            throw new NotFoundHttpException("Page not found");
        }
    }
}