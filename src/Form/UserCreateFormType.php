<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])
        ->add('email', TextType::class, [
            'label' => 'Email :',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])
        ->add('save', SubmitType::class, [
            'label' => 'Créé l\'emprunteur',
            'attr' => [
                'class' => 'btn btn-primary'
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
