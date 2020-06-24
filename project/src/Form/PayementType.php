<?php

namespace App\Form;

use App\Entity\Payement;
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
            ->add('cardId')
            ->add('cardPass')
            ->add('datePayement',DateType::class, [
                'attr' => ['class' =>'form-contol datetimepicker'],
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'd/m/Y'
            ])
            ->add('timePayement', TimeType::class, [
                'attr' => ['class' => 'form-control datetimepicker2'],
                'html5' => false,
                'widget' => 'single_text',
                'input_format' => 'H:i'
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'classe'=>'brn btn-primary'
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
