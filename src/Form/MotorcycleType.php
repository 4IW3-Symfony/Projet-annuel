<?php

namespace App\Form;

use App\Entity\Motorcycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MotorcycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motorcycle_images', CollectionType::class, [
                'entry_type' => MotorcycleImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'label' => false,
                'delete_empty' => true,
                'by_reference' => false,
            ])
            ->add('name')
            ->add('power')
            ->add('numberplate')
            ->add('description')
            ->add('km')
            ->add('year')
            ->add('status', ChoiceType::class, [
                'choices'  =>
                Motorcycle::STATUS
            ])
            ->add('licenceType')
            ->add('model');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Motorcycle::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'block_motorcycle';
    }
}
