<?php

/**
 * Home Controller containing the update and home page routes
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


use Jedi\UserBundle\Form\UpdateFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Home Controller Doc Comment
 *
 * @category HomeController
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class HomeController extends Controller
{
    /**
     * Home page to shown to authenticated users
     *
     * @param Request $request to handle request data
     *
     * @return string
     *
     * @Template()
     * @Route("/",name="home_page")
     */
    public function homeAction(Request $request)
    {
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
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
     *
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
            $em = $this->getDoctrine()->getManager();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setAddress($data['address']);
            $user->setGender($data['gender']);

            if ('' !== $user->getPlainPassword()) {
                $encode_object = $this->container->get('password.encode');
                $user->setPassword($encode_object->encodePassword($user, $user->getPlainPassword()));
            }

            $em->persist($user);
            $em->flush();
            /** flashbag to show user only once */
            $request->getSession()->getFlashBag()->add('success','Successfully Updated the profile');
            $url = $this->generateUrl('home_page');

            return $this->redirect($url);
        }
        return array('form'=>$form->createView());
    }


    /**
     * @Route("/check_email",name="checkEmail")
     */
    public function checkEmailAction()
    {
        $email = ($this->get('request')->request->get('email'));
        $response = array();
        $user = $this->getUser();
        $isExist = $this->container->get('email.check')->checkEmailExists($user, $email);
        if ($isExist) {
            $response = array('error' => 'Email id already exists');
        } else {
            $user->setEmail($email);
        }
        $response = new JsonResponse($response);
        return $response;
    }
}