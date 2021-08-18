<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\OrderDetails;
use App\Service\PaginationService;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountCommentController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Pour afficher tous les commentaires d'un utilisateur sur les produits qu'il a achetés
     * 
     * @Route("/compte/mes-commandes/mes-commentaires/{page<\d+>?1}", name="account_comments")
     */
    public function index(ReviewRepository $repo, $page, PaginationService $pagination): Response
    {
        
        //afficher tous les commentaires
        $repo = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $repo->findAll();

        $pagination->setEntityClass(Review::class)
                   ->setPage($page);

        // $commentaires = $this->entityManager->getRepository(Review::class)->findUserComments($this->getuser());

        // dd($commentaires);

        return $this->render('account/review.html.twig', [
            'reviews' => $reviews,
            'pagination' => $pagination,
        ]);
    }

}
