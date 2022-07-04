<?php

namespace App\Form;

use DateTime;
use App\Entity\Rental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RetalReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_start',DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new DateTime('now'))->format('Y-m-d'),
                ],
            ])
            ->add('date_end', DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new DateTime('now'))->format('Y-m-d'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
