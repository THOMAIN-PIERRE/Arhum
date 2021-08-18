<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', CKEditorType::class,  [
                'label' => 'COMMENTAIRE',
                'label_attr' => [
                    'class' => 'font-weight-bold',
                    'style' => 'font-size: 1.5rem',
                ],
                'attr' => [
                    'placeholder' => 'Saisissez votre commentaire'
                ]
            ])  
            ->add('note', IntegerType::class, [
                'label' => 'EVALUATION',
                'label_attr' => [
                    'class' => 'font-weight-bold',
                    'style' => 'font-size: 1.5rem',
                ],
                'attr' => [
                    'placeholder' => 'Votre note entre 0 et 5',
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "ENVOYER",
                'attr' => [
                    'class' => 'col-md-12 bg-success text-light font-weight-bold'
                ]
            ])
                
            
            // ->add('note')
            // ->add('comment')
            // ->add('createdAt')
            // ->add('user')
            // ->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
