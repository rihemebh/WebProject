<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('First_Name',TextType::class,array(
                'attr'=> array(
                    'class' =>'organize-form ',
                    'placeholder'=>'First Name'
                )
            ))
            ->add('Last_Name',TextType::class,array(
                'attr'=> array(
                    'class' =>'organize-form ',
                    'placeholder'=>'Last Name'
                )
            ))
            ->add('Email',TextType::class,array(
                'attr'=> array(
                    'class' =>'organize-form ',
                    'placeholder'=>'Email Address'
                )
            ))
            ->add('Password', RepeatedType::class, [
                'type' =>PasswordType::class,
                'first_options'  => array(
                    'attr'=>array(
                        'class' => 'organize-form ',
                        'placeholder'=>'New Password'
                    )
                ),
                'second_options' => array(
                    'attr'=>array(
                        'class' => 'organize-form ',
                        'placeholder'=>'Retype New Password',
                        'invalid_message' => 'Passwords Do Not Match'
                    )
                ),
                'second_name'=>'confirm',
                'first_name'=>'password',

            ])
            ->add('Phone_Number',NumberType::class,array(
                'attr'=> array(
                    'class' =>'organize-form ',
                    'placeholder'=>'Phone Number'
                )
            ))
            ->add('User_Name',TextType::class,array(
                'attr'=> array(
                    'class' =>'organize-form ',
                    'placeholder'=>'User Name'
                )
            ))
            ->add('Save_Changes',SubmitType::class,array(
                'attr'=>array('class'=>'button btn btn-primary')
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
