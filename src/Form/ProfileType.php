<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileType extends AbstractType
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
                'Mme' => "0",
                'Mr' => "1",
            ],
            'attr' => [
                'class' => 'row border border-dark',
                'style' => 'font-size: 1rem; font-weight: bold'

            ],
            'multiple' => false,
            'expanded' => true,
        ])
        // ->add('email', EmailType::class,  [
        //     'label' => 'Email',
        //     'label_attr' => [
        //         'style' => 'font-size: 1.1rem; font-weight: bold',
        //     ],
        //     'constraints' => new Length([
        //         'min' => 2,
        //         'max' => 60,
        //     ]),
        //     'attr' => [
        //         'placeholder' => 'Merci de saisir votre email'
        //     ]
        // ])
        // ->add('avatar', UrlType::class, [
        // 'label' => 'Avatar', 
        //     'attr' => [
        //     '   placeholder' => 'Url de votre avatar'
        // ]
        // ])
        ->add('firstname', TextType::class,  [
            'label' => 'Prénom',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            // 'constraints' => new Length([
            //     'min' => 2,
            //     'max' => 60,
            // ]),
            'attr' => [
                'placeholder' => 'Saisir votre nom'
            ]
        ])
        ->add('lastname', TextType::class,  [
            'label' => 'Nom',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            // 'constraints' => new Length([
            //     'min' => 2,
            //     'max' => 60,
            // ]),
            'attr' => [
                'placeholder' => 'Saisir votre prénom'
            ]
        ])
        ->add('publicName', TextType::class,  [
            'label' => 'Nom public*',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            // 'constraints' => new Length([
            //     'min' => 2,
            //     'max' => 60,
            // ]),
            'attr' => [
                'placeholder' => 'Saisir votre pseudo'
            ]
        ])
        ->add('avatar', FileType::class, [
            'label' => "Avatar",
            // 'required' => false,
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'required' => false,
            //Le champs image n'est pas lié à la base de données car on fixe mapped à false
            'mapped' => false,
            'constraints' => [
                new Image([
                    'maxSize' => '2M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a JPG or PNG image',
                ])
            ],
            'attr' => [
                // 'class' => 'custom-file-input custom-file-label',
                ]
        ])
        
        ->add('submit', SubmitType::class, [
            'label' => "SAUVEGARDER",
            'attr' => [
                'class' => 'bg-warning text-dark',
                'style' => 'font-size: 1.5rem; font-weight: bold',
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
