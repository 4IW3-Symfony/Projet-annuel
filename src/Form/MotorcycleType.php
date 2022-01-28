<?php

namespace App\Form;

use App\Entity\Motorcycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotorcycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('power')
            ->add('numberplate')
            ->add('description')
            ->add('km')
            ->add('year')
            ->add('LicenceType')
            ->add('user')
            ->add('model')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Motorcycle::class,
        ]);
    }
}
