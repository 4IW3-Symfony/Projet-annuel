<?php

namespace App\Form;

use App\Entity\MotorcycleImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MotorcycleImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'delete_label' => 'Remove Image',
                'allow_delete' => true,

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotorcycleImage::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'block_motorcycle_images';
    }
}
