<?php

namespace Jedi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jedi\UserBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpdateFormType extends AbstractType
{
    /**
     * Update form to register users
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder->add(
            'username',TextType::class,
            array(
                'attr' => array(
                    'placeholder'=>'Enter Username',
                    'class'=> 'form-control'
                )
            )
        )->add(
            'firstname', TextType::class, array(
                'attr' => array(
                    'placeholder'=>'Enter Firstname',
                    'class'=> 'form-control'
                )
            )
        )->add(
            'lastname', TextType::class, array(
                'attr' => array(
                    'placeholder'=>'Enter Lastname',
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
        )->add('gender', ChoiceType::class, array(

                'choices'  => array(
                    'Female' => 'female',
                    'Male' => 'male',
                ),
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
                'data' => $user->getGender()
            )
        )->add(
            'address', TextareaType::class,
            array(
                'attr' => array(
                    'placeholder'=>'Enter Address',
                    'class'=> 'form-control',
                    'rows' => 5
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
            'user' => null
        ));
    }
}



