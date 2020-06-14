<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('House_address_number',TextType::class,array(
                'attr'=>array(
                    'class'=> 'organize-form'
                )
            ))
            ->add('Street',TextType::class,array(
                'attr'=>array(
                    'class'=> 'organize-form'
                )
            ))

            ->add('City', TextType::class, array(
                'attr' => array(
                    'class' => 'organize-form'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'This Field is Required',
                    ])]
            ))
            ->add('Code', IntegerType::class, array(
                'attr' => array(
                    'class' => 'organize-form'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'This Field is Required',
                    ]),
                    new Length([
                        'min' => 4,
                        'exactMessage'=>"Code Must be 4 digit long",
                        'max' => 4,
                    ])]
            ))
            ->add('Save',SubmitType::class,array(
                'attr'=>array(
                    'class'=>'btn save1 '
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
