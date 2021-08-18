<?php

namespace App\Controller\Admin;

use App\Entity\OpenHours;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OpenHoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OpenHours::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('entitled', 'Intitulé de la grille horaire'),
            TextField::new('mondayAM', 'Lundi matin'),
            TextField::new('mondayPM', 'Lundi après-midi'),
            TextField::new('tuesdayAM', 'Mardi matin'),
            TextField::new('tuesdayPM', 'Mardi après-midi'),
            TextField::new('wednesdayAM', 'Mercredi matin'),
            TextField::new('wednesdayPM', 'Mercredi après-midi'),
            TextField::new('thursdayAM', 'Jeudi matin'),
            TextField::new('thursdayPM', 'Jeudi après-midi'),
            TextField::new('fridayAM', 'Vendredi matin'),
            TextField::new('fridayPM', 'Vendredi après-midi'),
            TextField::new('saturdayAM', 'Samedi matin'),
            TextField::new('saturdayPM', 'Samedi après-midi'),

        ];
    }
}
