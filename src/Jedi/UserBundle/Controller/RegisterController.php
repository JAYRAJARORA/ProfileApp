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
     * Register the users
     *
     * @Route("/register",name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        /** redirect already registered users */
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('home_page'));
        }
        /** register form */
        $form = $this->createForm(RegisterFormType::class);

        /** handles validation for the user object coming */
        $form->handleRequest($request);

        /** if submitted as post and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encode_object = $this->container->get('password.encode');
            $user->setPassword($encode_object->encodePassword($user,$user->getPlainPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            /** flashbag to show user only once */
            $request->getSession()->getFlashBag()->add('success','Successfully Registered.Kindly Login.');
            $url = $this->generateUrl('login_form');

            return $this->redirect($url);
        }
        return array('form'=>$form->createView());
    }


}