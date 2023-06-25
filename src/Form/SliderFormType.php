<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SliderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photo', FileType::class, [
            'label' => "Image",
            'data_class' => null,
            'mapped' => false,
            'attr' => [
                'value' => $options['photo'] !== null ? $options['photo'] : ''
            ],
            'constraints' => [
                new Image([
                    'mimeTypes' => ['image/jpeg', 'image/png'],
                    'maxSize' => '5M'
                ])
            ],
        ])
        ->add('ordre', TextareaType::class, [
            'label' => 'Ordre',
            'constraints' => [
                new NotBlank(),
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => $options['photo'] === null ? 'Créer' : 'Modifier',
            'validate' => false,
            'attr' => [
                'class' => 'my-5 d-block mx-auto btn btn-outline-warning col-5'
            ]
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
            'allow_file_upload' => true,
            'photo' => null
        ]);
    }
}
