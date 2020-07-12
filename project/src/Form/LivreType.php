<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_livre')
            ->add('prix')
            ->add('type')
            ->add('description')
            ->add('auteur')
            ->add('path')
            ->add('image', FileType::class, array(
                'mapped'=> false,
                'required'=> false,
                'empty_data' =>'empty'

            ))
            ->add('categories')
            ->add('language')
            ->add('done', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
