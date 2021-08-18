<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('gender', ChoiceType::class,  [
            'label' => 'Civilité',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
                'class' => 'ml-2',
            ],
            'choices' => [
                'Madame' => "0",
                'Monsieur' => "1",
            ],
            'attr' => [
                'class' => 'row',
                'style' => 'font-size: 1rem; font-weight: bold'
            ],
            'multiple' => false,
            'expanded' => true,
        ])
            ->add('firstname', TextType::class,  [
                'label' => 'Votre prénom',
                'label_attr' => [
                    'style' => 'font-size: 1.1rem; font-weight: bold',
                ],
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30,
                ]),
                'attr' => [
                    'placeholder' => 'Saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class,  [
                'label' => 'Votre nom',
                'label_attr' => [
                    'style' => 'font-size: 1.1rem; font-weight: bold',
                ],
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 40,
                ]),
                'attr' => [
                    'placeholder' => 'Saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class,  [
                'label' => 'Votre email',
                'label_attr' => [
                    'style' => 'font-size: 1.1rem; font-weight: bold',
                ],
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 60,
                ]),
                'attr' => [
                    'placeholder' => 'Saisir votre email'
                ]
            ]) //je demande d'ajouter un input email
            ->add('password',  RepeatedType::class,  [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'style' => 'font-size: 1.1rem; font-weight: bold',
                    ],
                    'attr' => [
                        'placeholder' => 'Saisir votre mot de passe'
                    ],
            ],
                'second_options' => ['label' => 'Confirmez votre mot de passe',
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'style' => 'font-size: 1.1rem; font-weight: bold',
                    ],
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe'
                    ]
            ],
            ])
            ->add('useTerms', CheckboxType::class, [
                'label' => 'J\'accepte que mes informations personnelles soient stockés dans la base de données de "Ma boutique". J\'ai bien noté qu\'en aucun cas, ces données ne seront cédées à des tiers.',
                'required' => true,
                'mapped' => false,
            ])
            ->add('captcha', RecaptchaType::class, [
                // You can use RecaptchaSubmitType
                // "groups" option is not mandatory
                'constraints' => new Recaptcha2(['groups' => ['create']]),
            ])
            ->add('submit', SubmitType::class, [
                'label' => "M'INSCRIRE",
                'attr' => [
                    'class' => 'bg-warning text-dark border border-dark'
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

