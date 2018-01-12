<?php

namespace Jedi\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

class HomeController extends Controller
{
    /**
     *Home page to shown to authenticated users
     *
     * @Template()
     * @Route("/",name="home_page")
     */
    public function homeAction()
    {
        /** not allow entry for unauthenticated users */
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('login_form'));
        }

        /** @var EntityManager $em */
        $em =   $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneByEmailOrUsername('wayne');
        return array('user'=> $user);
    }
}