<?php

namespace App\Controller\Admin;

use App\Entity\Characteristic;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CharacteristicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Characteristic::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('productName', 'Nom du produit'),
            TextField::new('type', 'Type d\'alcool'),
            TextField::new('origin', 'Provenance'),
            TextField::new('label', 'Label'),
            TextField::new('distillation', 'Méthode de distillation'),
            TextField::new('aging', 'Vieillissement'),
            IntegerField::new('degree', 'Degré'),
            TextEditorField::new('rewards', 'Récompenses'),
            IntegerField::new('vintage', 'Millésime'),
           
        ];
    }
}
