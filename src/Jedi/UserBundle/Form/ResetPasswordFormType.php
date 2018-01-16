<?php

namespace Jedi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ResetPasswordFormType extends AbstractType
{
    /**
     *Reset form to reset the password
     *
     * @param FormBuilderInterface $builder
     * @param array $options
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