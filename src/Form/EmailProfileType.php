<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmailProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class,  [
            'label' => 'Email',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'constraints' => new Length([
                'min' => 2,
                'max' => 60,
            ]),
            'attr' => [
                'placeholder' => 'Merci de saisir votre email'
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
