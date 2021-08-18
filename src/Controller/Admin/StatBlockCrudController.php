<?php

namespace App\Controller\Admin;

use App\Entity\StatBlock;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StatBlockCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return StatBlock::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            IdField::new('id')->hideOnForm(),
            IntegerField::new('number', 'Chiffre'),
            TextField::new('unit', 'Unité du chiffre'),
            TextField::new('text', 'Texte'),
            ImageField::new('icon')
            ->setBasePath('uploads/statIcon')
            ->setUploadDir('public/uploads/statIcon')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
        ];
    }
}
