<?php

namespace App\Form;

use App\Entity\Rental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_start', DateTimeType::class, [
                'date_label' => 'Start',
            ])
            ->add('date_end', DateTimeType::class, [
                'date_label' => 'End',
            ])
            ->add('status')
            ->add('km_start')
            ->add('km_end')
            ->add('motorcycle');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
