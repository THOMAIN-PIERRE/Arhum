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

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('avatar', FileType::class, [
            'label' => "Avatar",
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'required' => true,
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
                    'mimeTypesMessage' => 'PMerci de téléverser une image au format JPG ou PNG',
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

