<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
          $builder
              ->add('oldPassword', PasswordType::class, array(
                  'label'=>'Current Password',
                  'label_attr'=>array(
                      'class'=>'label'),
                  'mapped' => false,
                  'attr' => array(
                      'class' => 'organize-form'
                  )
              ))
              ->add('Password', RepeatedType::class, array(
                  'type' => PasswordType::class,
                  'invalid_message' => 'Passwords Do Not Match',
                  'first_options'  => ['label' => 'Password :','label_attr'=>['class'=>'label']],
                  'second_options' => ['label' => 'Repeat Password :','label_attr'=>['class'=>'label']],
                  'options' => array(
                      'attr' => array(
                          'class' => 'organize-form'
                      )
                  ),
                  'first_name'=>'New',
                  'second_name'=>'confirm',
                  'required' => true,
              ))
              ->add('Change_Password', SubmitType::class, array(
                  'attr' => array(
                      'class' => 'btn save'
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
