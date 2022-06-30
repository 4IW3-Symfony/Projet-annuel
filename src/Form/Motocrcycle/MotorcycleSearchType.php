<?php

namespace App\Form\Motocrcycle;

use App\Entity\Motorcycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotorcycleSearchType extends AbstractType
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
            ->add('status')
            ->add('slug')
            ->add('Cp')
            ->add('City')
            ->add('Localisation')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('licenceType')
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
