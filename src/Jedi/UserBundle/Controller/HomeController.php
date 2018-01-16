<?php

namespace Jedi\UserBundle\Controller;

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
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
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
    public function updateAction()
    {
        return array();
    }

}