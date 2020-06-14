<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array(
                    'attr' => array(
                        'class' => 'form-control organize-form',
                    ),
                ),
                'second_options' => array(
                    'constraints' => [
                        new NotBlank([
                            'message' => 'This Field is Required',
                        ])],
                    'attr' => array(
                        'class' => 'form-control  organize-form',
                    )
                ),
                'invalid_message' => 'Passwords Do Not Match',
                'second_name' => 'confirm',
                'first_name' => 'new',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This Field is Required',
                    ]),
                    new Length([
                        'min' =>8,
                        'minMessage'=>"Code Must be 4 digit long"
                    ])]
            ])
            ->add('oldPass', PasswordType::class, array(
                'attr' => array(
                    'class' => 'form-control  organize-form',
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'This Field is Required',
                    ])]
            ))
            ->add('Save_Password', SubmitType::class, array(
                'attr' => array('class' => ' btn save')
            ));;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
