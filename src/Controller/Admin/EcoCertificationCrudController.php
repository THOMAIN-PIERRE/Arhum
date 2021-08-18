<?php

namespace App\Controller\Admin;

use App\Entity\EcoCertification;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EcoCertificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EcoCertification::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre du label'),
            ImageField::new('logo', 'Logo')
            ->setBasePath('uploads/ecoCertLogo')
            ->setUploadDir('public/uploads/ecoCertLogo')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextEditorField::new('description', 'Contenu du label'),
        ];

    }
}
