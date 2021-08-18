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

class IdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('gender', ChoiceType::class,  [
            'label' => 'Civilité',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'choices' => [
                'Madame' => "0",
                'Monsieur' => "1",
            ],
            'attr' => [
                'class' => 'row border border-dark',
                'style' => 'font-size: 1rem; font-weight: bold'

            ],
            'multiple' => false,
            'expanded' => true,
        ])
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