<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])
            // ->add('subject', TextType::class, [
            //     'label' => 'Objet',
            //     'attr' => [
            //         'placeholder' => 'Merci de saisir l\'objet du message'
            //     ]
            // ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Objet',
                'attr' => [
                    'placeholder' => 'Merci de saisir l\'objet du message'
                ],
                'choices' => [
                    '' => "",
                    'Suggestion client' => "Suggestion client",
                    'Demande d\'information' => "Demande d'information",
                    'Retour marchandise' => "Retour marchandise",
                    'Problème de facturation' => "Problème de facturation",
                    'Colis endommagé, abîmé' => "Colis endommagé, abîmé",
                    'Autre' => "Autre",
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Votre message',
                'attr' => [
                    'placeholder' => 'En quoi pouvons-nous vous aider ?'
                ]
            ])
            ->add('captcha', RecaptchaType::class, [
                // You can use RecaptchaSubmitType
                // "groups" option is not mandatory
                'constraints' => new Recaptcha2(['groups' => ['create']]),
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'ENVOYER',
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
