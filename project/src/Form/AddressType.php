<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('House_address_number',TextType::class,array(
                'label'=>'House Number :',
                'label_attr'=>array(
                    'class'=>'ad'
                ),
                'attr'=>array(
                    'class'=> 'organize-form'
                )
            ))
            ->add('Street',TextType::class,array(
                'label'=>'Street :',
                'label_attr'=>array(
                    'class'=>'ad'
                ),
                'attr'=>array(
                    'class'=> 'organize-form'
                )
            ))

            ->add('City',TextType::class,array(
                'label'=>'City :',
                'label_attr'=>array(
                    'class'=>'ad'
                ),
                'attr'=>array(
                    'class'=> 'organize-form'
                )
            ))
            ->add('Code',IntegerType::class,array(
                'label'=>'Code :',
                'label_attr'=>array(
                    'class'=>'ad'
                ),
                'attr'=>array(
                    'class'=> 'organize-form'
                )
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
