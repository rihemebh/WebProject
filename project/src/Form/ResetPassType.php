<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Email_Address',EmailType::class,
            array(
                'label'=>' Email Address :',
             'attr'=>array(
                 'class'=>'organize-form form-control',
                 'placeholder'=>'Email Address'
             ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'This Field is Required',
                    ])]
            ))
            ->add('Submit',SubmitType::class,array (
                'attr'=>array(
                    'class'=>'btn save'
                )

                )
    )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
