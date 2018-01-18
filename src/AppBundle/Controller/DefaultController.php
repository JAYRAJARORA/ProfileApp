<?php
/**
 * Auto generated App Bundle using generate Bundle
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  AppBundle
 * @package   AppBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AppBundle Doc Comment
 *
 * @category AppBundle
 * @package  AppBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  Symfony is released under the MIT license, and the license
 * block has to be present at the top of every PHP file, before the namespace.
 * @link     http://pear.php.net/package/PackageName
 */
class DefaultController extends Controller
{
    /**
     * Default controller for symfony
     *
     * @param Request $request request object coming
     *
     * @return string
     *
     * @Route("/symfony", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
            'default/index.html.twig',
            array(
            'base_dir' => realpath(
                $this->container->getParameter(
                    'kernel.root_dir'
                )
                .'/..'
            ).DIRECTORY_SEPARATOR,
            )
        );
    }
}
