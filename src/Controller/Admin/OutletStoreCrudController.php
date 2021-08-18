<?php

namespace App\Controller\Admin;

use App\Entity\OutletStore;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OutletStoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OutletStore::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('storeAddress', 'Adresse de la boutique'),
            ImageField::new('mainPicture', 'Image principale')
            ->setBasePath('uploads/outletStore')
            ->setUploadDir('public/uploads/outletStore')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextareaField::new('presentation', 'Présentation de la boutique'),
            NumberField::new('latitude', 'Latitude'),
            NumberField::new('longitude', 'Longitude'),
            ImageField::new('pictureOne', 'Espace de vente (Photo 1)')
            ->setBasePath('uploads/outletStore')
            ->setUploadDir('public/uploads/outletStore')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            ImageField::new('pictureTwo', 'Espace de vente (Photo 2)')
            ->setBasePath('uploads/outletStore')
            ->setUploadDir('public/uploads/outletStore')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            ImageField::new('pictureThree', 'Espace de vente (Photo 3)')
            ->setBasePath('uploads/outletStore')
            ->setUploadDir('public/uploads/outletStore')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            ImageField::new('pictureFour', 'Espace de vente (Photo 4)')
            ->setBasePath('uploads/outletStore')
            ->setUploadDir('public/uploads/outletStore')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextareaField::new('salesAreaDescription', 'Présentation de l\'espace de vente'),
            AssociationField::new('openHours'),
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
