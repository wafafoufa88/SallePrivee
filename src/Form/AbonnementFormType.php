<?php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AbonnementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'label' => "Titre"
        ])
        ->add('subtitre', TextType::class, [
            'label' => "subtitre"
        ])
        ->add('description',TextareaType::class, [
            'label' => 'Description'
        ])
        ->add('alias', TextType::class, [
            'label' => "alias"
        ])
       
            ->add('tarif', TextType::class, [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 6
                    ])
                ]

            ])
            
            ->add('duree',DateType::class,[
                'label'=>"date d'abonnement",
                
            ])

            ->add('photo', FileType::class, [
                'label' => "Image",
                'data_class' => null,
                'mapped' => false,
                //'attr' => [
            //'value' => $options['photo'] !== null ? $options['photo'] : ''
                //],
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'maxSize' => '5M'
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                //'label' => $options['photo'] === null ? 'Créer' : 'Modifier',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block mx-auto my-3 col-3 btn btn-outline-warning'
                ]
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
