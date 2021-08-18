<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            EmailField::new('email', 'Email'),
            TextField::new('publicName', 'Pseudo'),
            // TextField::new('password', 'Mot de passe'),
            ArrayField::new('roles', 'Rôle'),
            ImageField::new('avatar', 'Photo')
            ->setBasePath('uploads/avatar')
            ->setUploadDir('public/uploads/avatar')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            // DateField::new('birthday', 'Date de naissance'),
            BooleanField::new('gender', 'Homme ?'),
            DateField::new('createdAt', 'Inscrit le'),
        ];
    }
}
