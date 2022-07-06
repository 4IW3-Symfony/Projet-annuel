<?php

namespace App\Form\Motorcycle;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints;

class MotorcycleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville',null,[
                'attr' => ['value' => $options['ville']],
            ])

            ->add('Start', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['value' => $options['date_start']],
            ])
            ->add('End', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['value' => $options['date_end']],
                'constraints' => [
                
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData()['Start'];
                        $stop = $object;
        
                        if (is_a($start, \DateTime::class) && is_a($stop, \DateTime::class)) {
                            if ($stop->format('U') - $start->format('U') < 0) {
                                $context
                                    ->buildViolation('Stop must be after start')
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'ville' => null,
            'date_start' =>null,
            'date_end' =>null,
        ]);
    }
}
