<?php

/**
 * Twitter Controller containing the tweets url and a callback url
 * to check the authentication token and provide access with the access token
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  TweetsPage
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */

namespace Jedi\UserBundle\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class Twitter Controller Doc Comment
 *
 * @category TwitterController
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class TwitterController extends Controller
{
    /**
     * Action to retrieve the tweets from the twitter site.
     * First check if access token exists if yes validate the
     * credentials and retrieve tweets or else gain the access token by going
     * to the callback url.
     *
     * @return mixed Url redirect if user does'nt have the access token
     * or else tweets page with the first 25 tweets of the users.
     *
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
                array(
                    'oauth_callback' => $this->redirect(
                        $this->generateUrl('twitter_callback')
                    )
                )
            );
            $this->get('session')->set('oauth_token', $request_token['oauth_token']);
            $this->get('session')
                ->set('oauth_token_secret', $request_token['oauth_token_secret']);
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
     * Callback url to provide the access token to the user
     *
     * @return mixed Url redirect to the tweets page
     * with the access token in session set
     *
     * @Route("/callback",name="twitter_callback")
     */
    public function callbackAction()
    {
            $request_token = [];
            $request_token['oauth_token']= $this->get('session')
                ->get('oauth_token', null);
            $request_token['oauth_token_secret'] = $this->get('session')
                ->get('oauth_token_secret', null);
            $connection = new TwitterOAuth(
                $this->container->getParameter('consumer_key'),
                $this->container->getParameter('consumer_secret'),
                $request_token['oauth_token'],
                $request_token['oauth_token_secret']
            );
            $access_token = $connection->oauth(
                'oauth/access_token',
                array(
                    'oauth_verifier' => $this->get('request')
                        ->query->get('oauth_verifier')
                )
            );
            $this->get('session')->set('access_token', $access_token);
            return  $this->redirect($this->generateUrl('tweets'));
    }
}

