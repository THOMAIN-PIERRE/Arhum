<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
        ->add('addresses', EntityType::class, [
            'label' => false,
            'label_attr' => [
                'style' => 'color: orange; margin-bottom: 10px',
            ],
            'required' => true,
            'class' => Address::class,
            'choices' => $user->getAddresses(),
            'multiple' => false,
            'expanded' => true
        ])
        ->add('carriers', EntityType::class, [
            // 'label' => 'CHOIX DU TRANSPORTEUR',
            'label' => false,
            'label_attr' => [
                'style' => 'color: orange; margin-bottom: 10px',
            ],
            'required' => true,
            'class' => Carrier::class,
            'multiple' => false,
            'expanded' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'VALIDER MA COMMANDE',
            'attr' => [
                'class' => 'btn btn-success btn-block col-md-12 font-weight-bold'
            ]
        ])
    ;
}


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
