<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
//            ->add('q', TextType::class, [
//                'label'=> false,
//                'required'=>false,
//                'attr' =>[
//                    'placeholder' => 'Search'
//                ]
//            ] )
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
                   ' value'=>"200",
                    'class'=>"custom-range bg-black" ,
                    'min'=>"0",
                    'max'=>"200"
                ]
                ])
            ->add('categories', EntityType::class,[
                'required'=>false,
                'label'=>false,
                'class'=> Categorie::class,
                'expanded'=>true,
                'multiple'=>true

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            "method"=>'GET',
            'cerf_protection'=>false,
            'validation_groups' => false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
