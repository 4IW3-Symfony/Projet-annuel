<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Validator\Constraints\IsTrue;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => ['User' => 'ROLE_USER', 'Admin' => 'ROLE_OWNER'],
                    'multiple' => true,
                ]
            )

            ->add('email');
        // ->add('isVerified')

        // If the usePassword options is set to true,
        if ($options["usePassword"]) {
            $builder->add('password', RepeatedType::class, array(

                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],

                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ));
        }
        $builder->add('firstname')

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
            'usePassword' => true
        ]);
    }
}
