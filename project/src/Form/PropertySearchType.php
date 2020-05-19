<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author',TextType::Class, [
                'required'=>false,
                'label'=>false,
                'attr'=>[

                    'class'=>'form-control small',
                    'placeholder'=>"enter author's name"
                ]
            ])
            ->add('maxPrice',RangeType::class, [
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'class'=>"custom-range smaller" ,
                    'id'=>"MyRange",
                    'min'=>"0",
                    'max'=>"200"
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            "method"=>'get',
            'cerf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
