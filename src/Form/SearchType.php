<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Produit;
use App\Entity\Category;
use App\Data\SearchData;;
use App\Entity\Categorie;
use App\Entity\Conditionnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SearchType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('origin', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir une provenance'
                ]
            ])

            // ->add('initialiser', ResetType::class, [
            //     'label' => 'Ré-initialiser le champs',
            
            // ])

            // ->add('volume', TextType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'attr' => [
            //         'placeholder' => 'Type de conditionnement'
            //     ]
            //     // 'expanded' => true,
            //     // 'multiple' => true, 
            // ])

            //On récupère toutes les catégories disponibles en BDD
            ->add('categories', EntityType::class, [
                'label' => false,
                'label_attr' => [
                    'class' => 'font-weight-bold',
                    'style' => 'font-size: 2rem'
                ],
                'required' => false,
                'class' => Category::class,
                'attr' => [
                    'class' => 'row',
                    'style' => 'font-size: 1rem; font-weight: bold'
    
                ],
                'expanded' => true, // render check-boxes
                'multiple' => true,
                
            ])

            //On affiche les différents conditionnements disponibles
            ->add('volume', ChoiceType::class, [
                'choices' => [
                    '70 cL' => '70 cL',
                    '1 L' => '1 L',
                    '1,5 L' => '1,5 L',
                    'Cubi 3L' => 'Cubi 3L',
                    'Cubi 5L' => 'Cubi 5L',
                    'Mignonette 5cL' => '5 cL',
                    
                ],
                    'multiple'  => true,   
                    'expanded'  => true,
                    'label' => false,
                    'attr' => [
                        'class' => 'row',
                        'style' => 'font-size: 1rem; font-weight: bold'
        
                    ],
                    // 'attr' => [
                    //     // 'class' => 'w-50 btn-block btn-info p-1',
                    //     'class' => 'w-50 btn-block p-1',
                    // ]
            ])
                

            ->add('min', ChoiceType::class,[
                'choices' => [
                // 'Min' => '1',
                '0' => '0',
                '10' => '1000',
                '20' => '2000',
                '30' => '3000',
                '40' => '4000',
                '50' => '5000',
                '60' => '6000',
                '70' => '7000',
                '80' => '8000',
                '90' => '9000',
                '100' => '10000',
                '120' => '12000',
                '140' => '14000',
                '160' => '16000',
                '180' => '18000',
                '200' => '20000',
            ],
                'multiple'  => false,   
                'expanded'  => false, 
                'label' => 'Prix Min',
                'attr' => [
                    // 'class' => 'w-50 btn-block btn-info p-1',
                    'class' => 'w-50 btn-block p-1',
                ]
            ])

            ->add('max', ChoiceType::class,[
                'choices' => [
                // 'Max' => '0',
                '0' => '0',
                '10' => '1000',
                '20' => '2000',
                '30' => '3000',
                '40' => '4000',
                '50' => '5000',
                '60' => '6000',
                '70' => '7000',
                '80' => '8000',
                '90' => '9000',
                '100' => '10000',
                '120' => '12000',
                '140' => '14000',
                '160' => '16000',
                '180' => '18000',
                '200' => '20000',
            ],
                'multiple'  => false,   
                'expanded'  => false, 
                'label' => 'Prix Max',
                'attr' => [
                    'class' => 'w-50 btn-block p-1',
                ]
                
            ])

            ->add('promo', CheckboxType::class, [
                'label' => 'Promo !',
                'label_attr' => [
                    'class' => 'badge badge-warning text-dark m-auto',
                    'style' => 'font-size: 1rem'
                ],
                'required' => false,
            ])

            // ->add('min', NumberType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'attr' => [
            //         'placeholder' => 'Min'
            //     ]
            // ])

            // ->add('max', NumberType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'attr' => [
            //         'placeholder' => 'Max'
            //     ]
            // ])

            // ->add('promo', CheckboxType::class, [
            //     'label' => 'En promotion',
            //     'required' => false,
            // ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
            $resolver->setDefaults([
                'data_class' => Search::class,
                'method' => 'GET',
                'csrf_protection' => false
            ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}
