<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('First_Name',TextType::class , array(
                'attr' => array(
                    'class' => 'form-control',
                    'Placeholder'=>'First Name')))

            ->add('Last_Name',TextType::class,array(
                'attr'=>array(
                    'class' => 'form-control',
                    'Placeholder'=>'Last Name'
                )
            ))
            ->add('User_Name',TextType::class,array(
                'attr'=>array(
                    'class' => 'form-control adjust',
                    'Placeholder'=>'UserName'
                )
            ))
            ->add('Email',EmailType::class,array(
                'attr'=>array(
                    'class' => 'form-control',
                    'Placeholder'=>'Email'
                )
            ))
            ->add('Password', RepeatedType::class, [
                'type' =>PasswordType::class,
                'first_options'  => array(
                    'attr'=>array(
                        'class' => 'form-control',
                        'Placeholder'=>'Password'
                    ),
                ),
                'second_options' => array(
                    'attr'=>array(
                        'class' => 'form-control',
                        'Placeholder'=>'Password Check'
                    )
                ),
                'invalid_message' => 'Passwords Do Not Match',
                'second_name'=>'confirm',
                'first_name'=>'password'
            ])

            ->add('Phone_Number',IntegerType::class,array(
                'attr'=>array(
                    'class' => 'form-control adjust',
                    'Placeholder'=>'Phone Number'
                )
            ))
            ->add('Register',SubmitType::class,array(
                'attr'=>array(
                    'class' => 'btn',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
