<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\OrderDetails;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountFavoriteController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Pour afficher tous les produits commandés par un utilisateur
     * 
     * @Route("/compte/mes-commandes/mes-produits/{page<\d+>?1}", name="account_favorites")
     */
    public function index(): Response
    {
        // $orderDetails = $this->entityManager->getRepository(OrderDetails::class);

        // afficher tous les produits dans la page accueil
        $repo = $this->getDoctrine()->getRepository(OrderDetails::class);
        $favoriteProducts = $repo->findAll();

        // $pagination->setEntityClass(OrderDetails::class)
        //            ->setPage($pageProducts);

        return $this->render('account/favorites.html.twig', [
            'favoriteProducts' => $favoriteProducts,
            // 'pagination' => $pagination,
        ]);
    }


    // /**
    //  * Pour afficher tous les commentaires d'un utilisateur sur les produits qu'il a achetés
    //  * 
    //  * @Route("/favorites/comments", name="account_comments")
    //  */
    // public function comments(): Response
    // {
        
    //     // afficher tous les commentaires
    //     $repo = $this->getDoctrine()->getRepository(Review::class);
    //     $commentaires = $repo->findAll();

    //     return $this->render('account/comments.html.twig', [
    //         'commentaires' => $commentaires,
    //     ]);
    // }

}
