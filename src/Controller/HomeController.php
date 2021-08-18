<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Header;
use App\Entity\Product;
use App\Entity\Carousel;
use App\Entity\Partners;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // La définition de la SessionInterface dans ce controller ainsi que la dévclaration de la variable $cart et son envoie à TWIG 
        // permet d'afficher dans cette page au niveau de la navbar() le nombre d'articles contenu dans mon panier !
        // $cart = $session->get('cart');



        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        // dd($products);
        $carousels = $this->entityManager->getRepository(Carousel::class)->findAll();

        $repo = $this->getDoctrine()->getRepository(Partners::class);
        $partners = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'carousels' => $carousels,
            'partners' => $partners,
            // 'cart' => $cart,
        ]);
    }
}
