<?php

namespace Jedi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jedi\UserBundle\Entity\User;

class RegisterFormType extends AbstractType
{
    /**
     * Register form to register users
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',TextType::class,array(
            'attr' => array(
                'placeholder'=>'Enter Username',
                'class'=> 'form-control'
            )
            )
        )->add('email',EmailType::class,array(
                'label' => 'Email Address',
                'attr' => array(
                    'placeholder'=>'Enter Email Address',
                    'class'=> 'form-control',
                )
            )
        )->add('plainPassword',
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

    /**
     * Set the form to be set as a user object to be
     * further validate by the user entity class
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}