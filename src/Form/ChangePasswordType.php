<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('email', EmailType::class, [
        //     'disabled' => true, //l'utilisateur ne pourra changer la valeur de cet input !
        //     'label' => 'Mon adresse email'
        // ])
        // ->add('firstname', TextType::class, [
        //     'disabled' => true, //l'utilisateur ne pourra changer la valeur de cet input !
        //     'label' => 'Mon prénom'
        // ])
        // ->add('lastname', TextType::class, [
        //     'disabled' => true, //l'utilisateur ne pourra changer la valeur de cet input !
        //     'label' => 'Mon nom'
        //     ])
        ->add('old_password', PasswordType::class, [
            'label' => 'Mon mot de passe actuel',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'mapped' => false,
            'attr' => [
                'placeholder' => 'Veuillez saisir votre mot de passe actuel'
            ]
        ])
        ->add('new_password',  RepeatedType::class,  [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
            'label' => 'Mon nouveau mot de passe',
            'required' => true,
            'first_options' => ['label' => 'Mot de passe',
                'label' => 'Mon nouveau mot de passe',
                'label_attr' => [
                    'style' => 'font-size: 1.1rem; font-weight: bold',
                ],
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                ]
        ],
            'second_options' => ['label' => 'Confirmez votre mot de passe',
                'label' => 'Confirmation du mot de passe',
                'label_attr' => [
                    'style' => 'font-size: 1.1rem; font-weight: bold',
                ],
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre mot de passe'
                ]
        ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => "METTRE A JOUR",
            'attr' => [
                'class' => 'bg-warning text-dark'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
