<?php

namespace App\Form\Motorcycle;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MotorcycleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
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
            ->add('permis', ChoiceType::Class,[
                'choices' => [
                    'All' => 'All',
                    'A' => 'A',
                    'A2' => 'A2',
                ]
            ])
            ->add('marque', ChoiceType::Class,[
                'choices' =>[
                    ''=> '',
                    'Aprilia' => 'Aprilia',
                    'Beta' => 'Beta',
                    'BMW' =>'BMW',
                    'Cagiva' =>'Cagiva',
                    'Can-Am' =>'Can-Am',
                    'Dervi' =>'Dervi',
                    'Ducati' =>'Ducati',
                    'Fantic' =>'Fantic',
                    'Gas Gas' =>'Gas Gas',
                    'Gilera' =>'Gilera',
                    'Harley-Davidson' =>'Harley-Davidson',
                    'Honda' =>'Honda',
                    'Husaberg' => 'Husaberg',
                    'Husqvarna' =>'Husqvarna',
                    'Indian' =>'Indian',
                    'Italjet' =>'Italjet',
                    'Kawasaki' =>'Kawasaki',
                    'KTM' => 'KTM',
                    'Kymco' =>'Kymco',
                    'MBK' =>'MBK',
                    'Moto Guzzi' => 'Moto Guzzi' ,
                    'Peugeot' =>'Peugeot' ,
                    'Piaggio' => 'Piaggio',
                    'Sherco' => 'Sherco',
                    'Star Motorcycles' => 'Star Motorcycles',
                    'Suzuki' =>   'Suzuki',
                    'Sym' =>  'Sym' ,
                    'Triumph' =>'Triumph',
                    'Vespa' =>'Vespa' ,
                    'Victory Motorcycle' =>'Victory Motorcycle',
                    'Yamaha' =>'Yamaha',
                    
                ]
            ])
            ->add('prix_min',IntegerType::class,[
                'label' => 'Prix min',
                'attr' =>['min' => $options['prix_minimun'],
                            'max' => $options['prix_maximun']],

            ])
            ->add('prix_max',IntegerType::class,[
                'label' => 'Prix max',
                'attr' =>['max' => $options['prix_maximun'],
                          'min' => $options['prix_minimun'],],
                'constraints' => [
    
                new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                    $min = $context->getRoot()->getData()['prix_min'];
                    $max = $object;

                    if ($min > $max) {
                        $context
                            ->buildViolation('Prix doit être inférieur à max')
                            ->addViolation();
                    }
                }),
            ],

            ])
            ->add('year_min',IntegerType::class,[
                'label' => 'Année min',
                'attr' =>['min' => $options['year_minimun'],
                        'max' => $options['year_maximun'],],
                

            ])
            ->add('year_max',IntegerType::class,[
                'label' => 'Année max',
                'attr' =>['min' => $options['year_minimun'],
                        'max' => $options['year_maximun'],],
                'constraints' => [

                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $min = $context->getRoot()->getData()['year_min'];
                        $max = $object;
    
                        if ($min > $max) {
                            $context
                                ->buildViolation('Année doit être inférieur à max')
                                ->addViolation();
                        }
                    }),
                ],
            ])
            ->add('power_min',IntegerType::class,[
                'label' => 'Puissance min',
                'attr' =>['min' => $options['power_minimun'],
                        'max' => $options['power_maximun'],],

            ])
            ->add('power_max',IntegerType::class,[
                'label' => 'Puissance max',
                'attr' =>['min' => $options['power_minimun'],
                        'max' => $options['power_maximun'],],
                'constraints' => [

                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $min = $context->getRoot()->getData()['power_min'];
                        $max = $object;
    
                        if ($min > $max) {
                            $context
                                ->buildViolation('Puissance doit être inférieur à max')
                                ->addViolation();
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
            'prix_minimun' =>null,
            'prix_maximun' =>null,
            'year_minimun'=>null,
            'year_maximun' => null,
            'power_minimun' => null,
            'power_maximun' => null,
            'permis' => null,
            'marque' => null,
            'prix_min' => null,
            'prix_max' => null ,
            'year_min' => null,
            'year_max' => null ,
            'power_min' => null, 
            'power_max'=> null,
        ]);
    }
}
