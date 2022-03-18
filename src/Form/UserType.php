<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => ['User' => 'ROLE_USER', 'Admin' => 'ROLE_OWNER'],
                    'multiple' => true,
                ]
            )
            ->add('password')
            ->add('isVerified')
            ->add('firstname')
            ->add('lastname')
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Date of birth'
            ])
            ->add('driving_licence')
            ->add('id_card')
            ->add('address')
            ->add('city')
            ->add('zip');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'allow_extra_fields' => true,
        ]);
    }
}
