<?php


namespace App\Form;

use App\Entity\Livre;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_livre',TextType::Class, [
                'required'=>false,
                'label'=>false,
                'attr'=>[

                    'class'=>'form-control small',
                    'placeholder'=>"enter book's title"
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
