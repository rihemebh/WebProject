<?php


namespace App\Form;

use App\Entity\User;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName',TextType::Class, [
                'required'=>false,
                'label'=>false,
                'attr'=>[

                    'class'=>'form-control small',
                    'placeholder'=>"enter user's username"
                ]
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
