<?php

namespace App\Form\Motorcycle;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'attr' => ['value' => $options['ville'],'placeholder' => "Ville",],
                'required' => false,
            ])

            ->add('Start', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date("Y-m-d")],
                'required' => false,
            ])
            ->add('End', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['min' => date("Y-m-d")],
                'required' => false,
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
            ->add('A2', CheckboxType::Class,[
                'value' => true,
                'required' => false,
            ])
            ->add('A', CheckboxType::Class,[
                'value' => true,
                'required' => false,
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
                    
                ],
                'required' => false,
            ])
            ->add('prix_min',IntegerType::class,[
                'label' => 'Prix min',
                'attr' =>['min' => $options['prix_minimun'],
                            'max' => $options['prix_maximun']],
                'required' => false,

            ])
            ->add('prix_max',IntegerType::class,[
                'label' => 'Prix max',
                'attr' =>['max' => $options['prix_maximun'],
                          'min' => $options['prix_minimun'],],
                'constraints' => [
    
                new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                    $min = $context->getRoot()->getData()['prix_min'];
                    $max = $object;
                    if($max != null){
                        if ($min > $max) {
                        $context
                            ->buildViolation('Prix doit être inférieur à max')
                            ->addViolation();
                        }
                    }
                    
                }),
            ],
            'required' => false,

            ])
            ->add('year_min',IntegerType::class,[
                'label' => 'Année min',
                'attr' =>['min' => $options['year_minimun'],
                        'max' => $options['year_maximun'],],
                'required' => false,
                

            ])
            ->add('year_max',IntegerType::class,[
                'label' => 'Année max',
                'attr' =>['min' => $options['year_minimun'],
                        'max' => $options['year_maximun'],],
                'constraints' => [

                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $min = $context->getRoot()->getData()['year_min'];
                        $max = $object;
                        if($max != null){
                            if ($min > $max) {
                            $context
                                ->buildViolation('Année doit être inférieur à max')
                                ->addViolation();
                            }
                        }
                        
                    }),
                ],
                'required' => false,
            ])
            ->add('power_min',IntegerType::class,[
                'label' => 'Puissance min',
                'attr' =>['min' => $options['power_minimun'],
                        'max' => $options['power_maximun'],],
                'required' => false,

            ])
            ->add('power_max',IntegerType::class,[
                'label' => 'Puissance max',
                'attr' =>['min' => $options['power_minimun'],
                        'max' => $options['power_maximun'],],
                'constraints' => [

                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $min = $context->getRoot()->getData()['power_min'];
                        $max = $object;
                        if($max != null){
                            if ($min > $max) {
                            $context
                                ->buildViolation('Puissance doit être inférieur à max')
                                ->addViolation();
                        }
                        }
                        
                    }),
                ],
                'required' => false,

            ])
            ->add('recherche',SubmitType::class,[
                'label'=>'Rechercher',
                'attr' =>['class' => "btn btn-dark"],
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
