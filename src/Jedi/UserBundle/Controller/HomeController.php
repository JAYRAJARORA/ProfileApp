<?php

namespace Jedi\UserBundle\Controller;

use Jedi\UserBundle\Entity\User;
use Jedi\UserBundle\Form\RegisterFormType;
use Jedi\UserBundle\Form\UpdateFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     *Home page to shown to authenticated users
     *
     * @Template()
     * @Route("/",name="home_page")
     */
    public function homeAction(Request $request)
    {
        /** not allow entry for unauthenticated users */
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login_form'));
        }

        $username = $this->getUser()->getUserName();
        /** @var EntityManager $em */
        $em =   $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneByEmailOrUsername($username);
        return array('user'=> $user);
    }

    /**
     * Update profile of users
     * @Template()
     * @Route("/update",name="update")
     */
    public function updateAction(Request $request)
    {

        /** redirect already registered users */
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return $this->redirect($this->generateUrl('login_form'));
        }
        $data = null;
        /** update form */
        $form = $this->createForm(UpdateFormType::class, $data, array('user' => $this->getUser()));

        /** handles validation for the user object coming */
        $form->handleRequest($request);
        /** if submitted as post and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->getUser();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setAddress($data['address']);
            $user->setGender($data['gender']);
            if (strcmp($data['email'],$this->getUser()->getEmail())) {
                $user->setEmail($data['email']);
            }
            if ('' !== $user->getPlainPassword()) {
                $encode_object = $this->container->get('encode_password');
                $user->setPassword($encode_object->encodePassword($user, $user->getPlainPassword()));
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            /** flashbag to show user only once */
            $request->getSession()->getFlashBag()->add('success','Successfully Updated the profile');
            $url = $this->generateUrl('home_page');

            return $this->redirect($url);
        }
        return array('form'=>$form->createView());
    }
}