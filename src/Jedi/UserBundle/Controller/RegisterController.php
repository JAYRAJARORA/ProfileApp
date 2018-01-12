<?php

namespace Jedi\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Jedi\UserBundle\Entity\User;
use Jedi\UserBundle\Form\RegisterFormType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegisterController extends Controller
{
    /**
     * @Route("/register",name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('home_page'));
        }
        $form = $this->createForm(RegisterFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($this->encodePassword($user,$user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success','Successfully Registered.Kindly Login.');
            $url = $this->generateUrl('login_form');

            return $this->redirect($url);
        }
        return array('form'=>$form->createView());
    }

    private function encodePassword(User $user, $plainpassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainpassword, $user->getSalt());
    }

    private function authenticateUser(User $user)
    {
        // firewall name
        $providerKey = 'secured_area';
        $token = new UsernamePasswordToken($user,null,$providerKey, $user->getRoles());
        $this->getSecurityContext()->setToken($token);
    }
    public function getSecurityContext()
    {
        return $this->container->get('security.context');
    }
}