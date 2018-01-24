<?php

/**
 * Send email service for sending mail if email exists in the db
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  SendEmail
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class SendEmail  Doc Comment
 *
 * @category SendEmail
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class SendEmail
{
    private $_em;
    private $_templating;
    private $_mailer;
    private $_set_from_email;

    /**
     * SendEmail constructor.
     *
     * @param \Doctrine\ORM\EntityManager           $em             manager object
     * @param \Symfony\Bundle\TwigBundle\TwigEngine $templating     templating
     *                                                              service
     * @param \Swift_Mailer                         $mailer         mailer
     *                                                              service
     *                                                              to send mail
     * @param null                                  $set_from_email parameter
     *                                                              to set sent
     *                                                              from email
     */
    public function __construct(
        EntityManager $em,
        TwigEngine $templating,
        \Swift_Mailer $mailer,
        $set_from_email=null
    ) {
        $this->_em = $em;
        $this->_templating = $templating;
        $this->_mailer = $mailer;
        $this->_set_from_email = $set_from_email;
    }

    /**
     * Send email to the user and show appropriate messages accordingly
     *
     * @param string $email to verify
     *
     * @return array
     */
    public function sendEmail($email)
    {
        $repo = $this->_em->getRepository('UserBundle:User');
        $user = $repo->findOneBy(['_email'=> $email]);
        if ($user) {
            $rand_num = mt_rand();
            $user->setForgotPassId($rand_num);
            $epoch = time();
            $current_time = date(
                'Y-m-d H:i:s',
                $epoch
            );
            $date = new \DateTime($current_time);
            $user->setTokenTime($date);
            $this->_em->flush();
            $message = (
                new \Swift_Message('Reset Password Link for the Profile App')
            )
                ->setFrom($this->_set_from_email)
                ->setTo($email)
                ->setBody(
                    $this->_templating->render(
                        '@User/Security/sendemail.html.twig',
                        array(
                            'forgot_pass_id' => $rand_num
                        )
                    ),
                    'text/html'
                );

            $status= $this->_mailer->send($message);
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
        return $data;
    }
}