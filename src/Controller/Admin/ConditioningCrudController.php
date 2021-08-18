<?php

namespace App\Controller\Admin;

use App\Entity\Conditioning;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConditioningCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conditioning::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('container', 'Conditionnement (contenant)'),
            TextField::new('volume', 'Volume (contenu)'),
            TextField::new('conditioningType', 'Type de conditionnement'),
            TextField::new('color', 'Couleur'),
        ];
    }
}
