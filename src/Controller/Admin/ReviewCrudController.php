<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            // TextField::new('title'),
            // TextEditorField::new('description'),
            
                IntegerField::new('note', 'Note'),
                TextEditorField::new('comment', 'Contenu'),
                DateField::new('createdAt', 'Date commentaire'),
                TextField::new('author', 'Pseudo'),
                ChoiceField::new('status','Statut de modération')
                ->setChoices([
                    'Validé' => 'Validé',
                    'Non validé' => 'Non validé',
                ]),
                DateField::new('moderatedAt', 'Date modération'),
            ];
                // ->allowMultipleChoices(false)
                // ->renderExpanded(true)]
        
                
            
    }

}
