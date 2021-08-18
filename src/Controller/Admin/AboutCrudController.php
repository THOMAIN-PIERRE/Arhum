<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('title', 'Titre de l\'image'),
            TextEditorField::new('text', 'Légende de l\'image'),
            ImageField::new('picture')
            ->setBasePath('uploads/aboutPicture')
            ->setUploadDir('public/uploads/aboutPicture')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            
        ];
    }
}
