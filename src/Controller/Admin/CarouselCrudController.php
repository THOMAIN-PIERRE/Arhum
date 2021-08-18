<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarouselCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carousel::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du slide'),
            TextEditorField::new('content', 'Contenu du slide'),
            TextField::new('btnTitle', 'Titre du bouton'),
            TextField::new('btnUrl', 'Url de destination du bouton'),
            // ImageField::new('illustration')->setBasePath('uploads/')->setFormTypeOptions(['mapped' => false, 'required' => false]),
            ImageField::new('illustration')
            ->setBasePath('uploads/carousel')
            ->setUploadDir('public/uploads/carousel')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
        ];

    }
}
