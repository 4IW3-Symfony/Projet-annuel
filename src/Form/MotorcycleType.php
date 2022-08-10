<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\Motorcycle;
use Doctrine\ORM\EntityRepository;
use App\Repository\BrandRepository;
use Symfony\Component\Validator\Constraints;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
            ->add('power',null,[
                'attr' =>["min" => 10],
            ])
            ->add('price',null,[
                'attr' =>["min" => 10],
            ])
            ->add('numberplate',null,[
                'constraints'=>[
                    new Constraints\Callback(function($object, ExecutionContextInterface $context){
                        if(preg_match('#[A-Z]{2}-[0-9]{3}-[A-Z]{2}#i',$object)){

                        }
                        else{
                            $context->buildViolation('Respecter Format AA-111-BB')->addViolation();

                        }
                    }),
                ]
            ])
            ->add('description')
            ->add('km',null,[
                'attr'=>['min'=>0],
            ])
            ->add('year',null,[
                'attr'=>['min'=>1970,'max'=>date("Y")],
            ])
            ->add('licenceType',null,[
                'required'=>true,
            ])
            ->add('model', EntityType::class,[
                'class' => Model::class,
                // 'query_builder' => function(EntityRepository $er)
                // { return $er->createQueryBuilder('model')->join('model.brand','b')->where('b.name = :name')->setParameter('name','Aprilia'); },
                'choices' => $options['group']->getModels(),
                'choice_label' => 'name',
              
            ])
            ->add('Localisation')
            ->add('City')
            ->add('Cp');
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
