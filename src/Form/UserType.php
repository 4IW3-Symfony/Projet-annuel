<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add(
            //     'roles', ChoiceType::class, [
            //         'choices' => ['ROLE_USER', 'ROLE_OWNER'],
            //     ]
            // )
            ->add('password')
            ->add('isVerified')
            ->add('firstname')
            ->add('lastname')
            ->add('dateOfBirth')
            ->add('driving_licence')
            ->add('id_card')
            ->add('address')
            ->add('city')
            ->add('zip')
            ->add('contact')
            ->add('licenceType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
