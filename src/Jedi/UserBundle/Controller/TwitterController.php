<?php

namespace Jedi\UserBundle\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TwitterController extends Controller
{
    /**
     * @Route("/twitter",name="tweets")
     * @Template()
     */
    public function getTweetsAction()
    {
        if (!$this->get('session')->get('access_token', null)) {
            $connection = new TwitterOAuth(
                $this->container->getParameter('consumer_key'),
                $this->container->getParameter('consumer_secret')
            );
            $request_token = $connection->oauth(
                'oauth/request_token',
                array('oauth_callback' => $this->redirect($this->generateUrl('twitter_callback')))
            );
            $this->get('session')->set('oauth_token', $request_token['oauth_token']);
            $this->get('session')->set('oauth_token_secret', $request_token['oauth_token_secret']);
            $url = $connection->url(
                'oauth/authorize',
                array('oauth_token' => $request_token['oauth_token'])
            );

            return $this->redirect($url);
        } else {
            $access_token = $this->get('session')->get('access_token');
            $connection = new TwitterOAuth(
                $this->container->getParameter('consumer_key'),
                $this->container->getParameter('consumer_secret'),
                $access_token['oauth_token'],
                $access_token['oauth_token_secret']
            );
            $statuses = $connection->get(
                'statuses/user_timeline',
                ['count' => 25, 'exclude_replies' => true]
            );
            return array(
              'statuses' => $statuses
            );
        }
    }

    /**
     * @Route("/callback",name="twitter_callback")
     */
    public function callbackAction()
    {
            $request_token = [];
            $request_token['oauth_token']= $this->get('session')->get('oauth_token', null);
            $request_token['oauth_token_secret'] = $this->get('session')->get('oauth_token_secret', null);
            $connection = new TwitterOAuth(
                $this->container->getParameter('consumer_key'),
                $this->container->getParameter('consumer_secret'),
                $request_token['oauth_token'],
                $request_token['oauth_token_secret']
            );
            $access_token = $connection->oauth(
                'oauth/access_token',
                array('oauth_verifier' => $this->get('request')->query->get('oauth_verifier'))
            );
            $this->get('session')->set('access_token', $access_token);
            return  $this->redirect($this->generateUrl('tweets'));
        }
}

