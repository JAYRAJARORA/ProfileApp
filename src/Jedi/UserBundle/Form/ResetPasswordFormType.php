<?php

/**
 * Reset Form to handle password to be updated
 *
 * PHP version 7.0
 *
 * LICENSE: This program is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @category  RegisterForm
 * @package   UserBundle
 * @author    Jayraj Arora <jayraja@mindfiresolutions.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/PackageName
 */
namespace Jedi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ResetPasswordFormType Doc Comment
 *
 * @category ResetPasswordForm
 * @package  UserBundle
 * @author   Jayraj Arora <jayraja@mindfiresolutions.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://pear.php.net/package/PackageName
 */
class ResetPasswordFormType extends AbstractType
{
    /**
     * Reset form to reset the password
     *
     * @param FormBuilderInterface $builder builder object to add field to the form
     * @param array                $options optional parameters sent along with form
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'plainPassword',
            RepeatedType::class,
            array(
                'type' => PasswordType::class,
                'label' => 'Password',
                'invalid_message' => 'The password fields must match.',
                'first_options'  => array(
                    'attr' => array(
                        'placeholder'=>'Enter Password',
                        'class'=> 'form-control',
                    ),
                ),
                'second_options'  => array(
                    'attr' => array(
                        'placeholder'=>'Enter Password Again',
                        'class'=> 'form-control',
                    ),
                )
            )
        );
    }
}
