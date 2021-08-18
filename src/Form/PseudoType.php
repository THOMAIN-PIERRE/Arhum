<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PseudoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('publicName', TextType::class,  [
            'label' => 'Nom public*',
            'label_attr' => [
                'style' => 'font-size: 1.1rem; font-weight: bold',
            ],
            'attr' => [
                'placeholder' => 'Saisir votre pseudo'
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
