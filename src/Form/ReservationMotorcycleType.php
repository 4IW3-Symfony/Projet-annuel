<?php

namespace App\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReservationMotorcycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_start',DateType::class,[
            'widget' => 'single_text',
            'label' => 'Début',
           
            'attr' => [
                'min' => (new DateTime('now'))->format('Y-m-d'),
            ],
        ])
        ->add('date_end', DateType::class,[
            'widget' => 'single_text',
            'label' => 'Fin',
            
            'attr' => [
                'min' => (new DateTime('now'))->format('Y-m-d'),
            ],
            'constraints' => [
            
                new Constraints\Callback(function($object, ExecutionContextInterface $context) {
        
                    $start = $context->getRoot()->get('date_start')->getData();
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
        ]);
    }
}
