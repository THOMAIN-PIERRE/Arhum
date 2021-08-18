<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $crudUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        // Ajout de "custom actions". En effet, easyAdmin connait les actions editer, modifier, ajouter, supprimer. Mais j'ai la possibilité de créer mes propres actions !
        // ATTENTION : la méthode "linkToCrudAction" permet de créer un lien avec une méthode que je vais créer dans ce même controller OrderCrudController
        // Nous avons la possibilité d'ajouter de petites icônes en les passant en 3ème paramètre 
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('updateDelivery');
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        
        return $actions
            // J'ajoute ici les actions que je souhaite afficher
            // 1er paramètre = page dans laquelle je veux afficher l'action
            // 2ème paramètre = action à réaliser
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    // Création d'une méthode action nommée updatePreparation qui va me servir à modifier mon entité !
    public function updatePreparation(AdminContext $context)
    {
        // Me permet de récupérer l'order que je veux modifier !
        $order = $context->getEntity()->getInstance();
        // Si tu rendres dans updatePreparation tu fais setState(2) = tu passes le statut de la commande à 2
        $order->setState(2);
        // Je pousse en BDD (nécéssite de créer un entityManager dans un constructeur)
        $this->entityManager->flush();
        // Ajout d'un message flash pour prévenir l'utilisateur que les moifications se sont bien passées
        $this->addFlash('notice', "<span style='color: blue;'><strong>La commande ".$order->getReference()." est <u>en cours de préparation</u>.</strong></span>");


        $url = $this->crudUrlGenerator->build()
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

            // Ajout de notification email pour confirmer que la commande est en cours de préparation ou de livraison (cf autres endroits ou on l'a fait)
            //$mail = new Mail();
            //$mail->send($order->getUser()->getEmail() ... construire notre email ...)



            return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color: green;'><strong>La commande ".$order->getReference()." est <u>en cours de livraison</u>.</strong></span>");

        $url = $this->crudUrlGenerator->build()
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

            // Ajout de notification email pour confirmer que la commande est en cours de préparation ou de livraison (cf autres endroits ou on l'a fait)
            //$mail = new Mail();
            //$mail->send($order->getUser()->getEmail() ... construire notre email ...)


            return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']); 
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            // DateField::new('createdAt', 'Passée le'),
            DateTimeField::new('createdAt', 'Passée le' ),
            TextField::new('user.FullName', 'Utilisateur'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total', 'Montant total')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            // BooleanField::new('isPaid', 'Payée'),
            TextField::new('reference', 'N° de commande'),
            TextField::new('stripeSessionId', 'N° de transaction (paiement)'),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex(),
            ChoiceField::new('state', 'Statut')->setChoices([
                'Non Payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3,
            ]),

        ];
    }
}

