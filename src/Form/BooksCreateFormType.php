<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BooksCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('author', TextType::class, [
            'label' => 'Auteur du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('release_date', DateType::class, [
            'label' => 'Date de parution du livre :',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('summary', TextareaType::class, [
            'label' => 'Résumé du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('category', TextType::class, [
            'label' => 'Genre du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('editor', TextType::class, [
            'label' => 'Editeur du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('status', ChoiceType::class, [
            'label' => 'Disponibilité du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ],
            'choices' => [
                'Emprunte' => '0',  // 0 quand emprunter
                'Disponible' => '1', // 1 quand disponible
            ],
        ])
        ->add('book_condition', ChoiceType::class, [
            'label' => 'Etat du livre :',
            'attr' => [
                'class' => 'form-control mb-4'
            ],
            'choices' => [
                'bon' => 'Bon état',
                'passable' => 'Etat passable',
                'mauvais' => 'Mauvais état',
            ],
        ])
        ->add('cover', FileType::class, [
            'label' => 'Votre cover :',
            'attr' => [
                'class' => 'ms-2'
            ],
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/jpeg',
                        'image/svg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Merci de choisir un cover valide ".jpg ,.jpeg ,.svg ,.png" et inférieur à 512Ko.',
                ])
            ],
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Créé le livre',
            'attr' => [
                'class' => 'btn btn-primary'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
