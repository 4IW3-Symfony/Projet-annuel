<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\Motorcycle;
use Doctrine\ORM\EntityRepository;
use App\Repository\BrandRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('name',null,[
                'label' => "Titre de l'annonce"
            ])
            ->add('power')
            ->add('price')
            ->add('numberplate')
            ->add('description')
            ->add('km')
            ->add('year')
            ->add('licenceType')
            ->add('model', EntityType::class,[
                'class' => Model::class,
                // 'query_builder' => function(EntityRepository $er)
                // { return $er->createQueryBuilder('model')->join('model.brand','b')->where('b.name = :name')->setParameter('name','Aprilia'); },
                'choices' => $options['group']->getModels(),
                'choice_label' => 'name',
              
            ])
            ->add('Localisation')
            ->add('City')
            ->add('Cp',null,['attr' => ['min' => 9000,'max'=>99999]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Motorcycle::class,
            'group' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'block_motorcycle';
    }
}
