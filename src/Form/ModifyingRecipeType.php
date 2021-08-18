<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ModifyingRecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre de votre recette',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Donnez un titre a votre recette',
            ]
        ])
        ->add('resume', TextareaType::class, [
            'label' => 'Résumé',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Court résumé de votre recette'
            ]
        ])
        ->add('text', CKEditorType::class, [
            'label' => 'Description',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Entrez une description'
            ]
        ])
        // ->add('img', FileType::class, [
        //     'label' => "Illustration",
        //     // 'required' => false,
        //     'label_attr' => [
        //         'style' => 'font-size: 1.1rem; font-weight: bold',
        //     ],
        //     'required' => true,
        //     //Le champs image n'est pas lié à la base de données car on fixe mapped à false
        //     'mapped' => false,
        //     'constraints' => [
        //         new Image([
        //             'maxSize' => '2M',
        //             'mimeTypes' => [
        //                 'image/jpeg',
        //                 'image/jpg',
        //                 'image/png',
        //             ],
        //             'mimeTypesMessage' => 'Please upload a JPG or PNG image',
        //         ])
        //     ],
        //     'attr' => [
        //         // 'class' => 'custom-file-input custom-file-label',

        //         ]
        // ])
        ->add('level', ChoiceType::class,  [
            'label' => 'Niveau de difficulté',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'choices' => [
                '' => "",
                'Facile' => "Facile",
                'Moyen' => "Moyen",
                'Difficile' => "Difficile",
            ],
            'attr' => [
                'class' => 'row border border-dark',
                'style' => 'font-size: 1rem; font-weight: bold'

            ],
            'multiple' => false,
            'expanded' => false,
        ])
        ->add('time', ChoiceType::class, [
            'label' => 'Temps de préparation (min)',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'choices' => [
                '' => "",
                '5' => "5",
                '10' => "10",
                '15' => "15",
                '20' => "20",
                '25' => "25",
                '30' => "30",
                '35' => "35",
                '40' => "40",
                '45' => "45",
                '50' => "50",
                '55' => "55",
                '60' => "60",
            ],
            'attr' => [
                'class' => 'row border border-dark',
                'style' => 'font-size: 1rem; font-weight: bold'

            ],
            'multiple' => false,
            'expanded' => false,
        ])
        ->add('portions', ChoiceType::class,  [
            'label' => 'Nombre de Portions',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'choices' => [
                '' => "",
                '1 personne' => "1 personne",
                '2 personnes' => "2 personnes",
                '3 personnes' => "3 personnes",
                '4 personnes' => "4 personnes",
                '5 personnes' => "5 personnes",
                '6 personnes' => "6 personnes",
                '7 personnes' => "7 personnes",
                '8 personnes' => "8 personnes",
                '9 personnes' => "9 personnes",
                '10 personnes' => "10 personnes",
            ],
            'attr' => [
                'class' => 'row border border-dark',
                'style' => 'font-size: 1rem; font-weight: bold'

            ],
            'multiple' => false,
            'expanded' => false,
        ])
        ->add('ingredients', CKEditorType::class, [
            'label' => 'Ingrédients',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Indiquez les ingrédients de votre recette'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'SAUVEGARDER LES MODIFICATIONS',
            'attr' => [
                'class' => 'btn-block btn-warning font-weight-bold text-dark border border-dark'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}
