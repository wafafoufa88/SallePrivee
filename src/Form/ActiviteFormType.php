<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActiviteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'label' => "Titre"
        ])
            ->add('description',TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('statut', TextType::class, [
                'label' => "statut"
            ])
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
            /*->add('salle',EntityType::class,[
                'class' =>Salle::class,
                'label' =>"salle" ,
                ])*/
                ->add('submit', SubmitType::class, [
                    'label' => $options['photo'] === null ? 'Créer' : 'Modifier',
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
            'data_class' => Activite::class,
            'allow_file_upload' => true,
            'photo' => null
        ]);
    }
}
