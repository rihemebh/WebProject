<?php

namespace App\Form;

use App\Entity\Payement;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePayement',\Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Chose a Day',
                'attr' => ['class' =>'form-control datetimepicker organize-form'],
            ])
            ->add('timePayement', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Chose a Time',
                'attr' => ['class' => 'form-control datetimepicker2 organize-form'],
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class'=>' save btn btn-primary btn-lg btn-block'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payement::class,
        ]);
    }
}
