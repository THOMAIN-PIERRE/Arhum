<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Intitulé de l\'adresse',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Nommez votre adresse',
            ]
        ])
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entrez votre prénom'
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entre votre nom'
            ]
        ])
        ->add('company', TextType::class, [
            'label' => 'Société',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'required' => false,
            'attr' => [
                'placeholder' => 'Entrez le nom de votre société (facultatif)'
            ]
        ])
        ->add('address', TextType::class, [
            'label' => 'Adresse',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => '10 avenue des Champs Elysés ...'
            ]
        ])
        ->add('zipCode', TextType::class, [
            'label' => 'Code postal',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entrez votre code postal'
            ]
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entrez votre ville'
            ]
        ])
        ->add('country', CountryType::class, [
            'label' => 'Pays',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'preferred_choices' => ['FR'],
            'attr' => [
                'placeholder' => 'Votre pays'
            ]
        ])
        ->add('phone', TelType::class, [
            'label' => 'Téléphone',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entrez votre téléphone'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'VALIDER',
            'attr' => [
                'class' => 'btn-block btn-warning border border-dark font-weight-bold text-dark'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
