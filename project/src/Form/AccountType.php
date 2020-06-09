<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('Profile_Picture')
            ->add('First_Name', TextType::class, array(
                'attr' => array(
                    'class' => 'organize-form form-control '
                )
            ))
            ->add('Last_Name', TextType::class, array(
                'attr' => array(
                    'class' => 'organize-form form-control '
                )
            ))
            ->add('Email', TextType::class, array(
                'attr' => array(
                    'class' => 'organize-form form-control'
                )
            ))
            ->add('Phone_Number', NumberType::class, array(
                'attr' => array(
                    'class' => 'organize-form form-control'
                )
            ))
            ->add('User_Name', TextType::class, array(
                'attr' => array(
                    'class' => 'organize-form form-control'
                )
            ))
            ->add('Save_Changes', SubmitType::class, array(
                'attr' => array('class' => ' btn save')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
