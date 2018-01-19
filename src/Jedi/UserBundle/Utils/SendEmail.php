<?php

namespace Jedi\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;

class SendEmail
{
    private $em;
    private $templating;
    private $mailer;
    private $set_from_email;

    public function __construct(EntityManager $em, TwigEngine $templating, \Swift_Mailer $mailer, $set_from_email=null)
    {
        $this->em = $em;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->set_from_email = $set_from_email;
    }

    public function sendEmail($email)
    {
        $repo = $this->em->getRepository('UserBundle:User');
        $user = $repo->findOneBy(['email'=> $email]);
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
            $this->em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom($this->set_from_email)
                ->setTo($email)
                ->setBody(
                    $this->templating->render(
                        '@User/Security/sendemail.html.twig',
                        array(
                            'forgot_pass_id' => $rand_num
                        )
                    ),
                    'text/html'
                );

            $status= $this->mailer->send($message);
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