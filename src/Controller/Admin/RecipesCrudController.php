<?php

namespace App\Controller\Admin;

use App\Entity\Recipes;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre de la recette'),
            TextEditorField::new('resume', 'Court résumé'),
            TextEditorField::new('text', 'Texte de la recette'),
            // TextField::new('btnTitle', 'Titre du bouton'),
            // TextField::new('btnUrl', 'Url de destination du bouton'),
            // ImageField::new('illustration')->setBasePath('uploads/')->setFormTypeOptions(['mapped' => false, 'required' => false]),
            ImageField::new('img')
            ->setBasePath('uploads/recipes')
            ->setUploadDir('public/uploads/recipes')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('level', 'Niveau de difficulté'),
            IntegerField::new('time', 'Préparation (en min)'),
            TextField::new('portions', 'Nombre de portions'),
            TextEditorField::new('ingredients', 'Liste des ingrédients'),
            DateField::new('createdAt', 'Date d\'ajout'),
            TextField::new('author', 'Auteur'),
            ChoiceField::new('status','Statut de modération')
                ->setChoices([
                    'Validé' => 'Validé',
                    'Non validé' => 'Non validé',
                ]),
            DateField::new('moderatedAt', 'Date de modération'),
        ];

    }
}
