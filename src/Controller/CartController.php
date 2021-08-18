<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Route permattant d'affichier au client la page récapitulative de son panier
     * 
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart)
    {
        // dd($cart->get());
        // dd($cartComplete);

        // Affichage des produits "plébiscités par les clients" (best products)
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);

        return $this->render('cart/index.html.twig',[
            // Affiche du contenu du panier grâce à la fonction getFull
            'cart' => $cart->getFull(),
            'products' => $products,

        ]);
    }    

     /**
     * Route menant à une petite fonction permattant d'ajouter des produits ou des quantités au panier
     *
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        //Grace a l'injection de Cart dans ma fonction, ma fonction index connaît ma variable $cart

        // dd($id);

        $cart->add($id);

        //redirection vers le panier
        return $this->redirectToRoute('cart');
    }
    
    /**
     * Route menant à une petite fonction permattant de supprimer le panier
     * 
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        // dd($id);
        //J'ai besoin d'appeler la fonction remove() pour effacer le panier !
        $cart->remove();
        
        //redirection vers la page produit
        return $this->redirectToRoute('products');
    }

    /**
     * Route permattant de supprimer un produit du panier
     * 
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id)
    {
        // dd($id);

        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * Route permettant de diminuer les quantités de nos produits
     * 
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        // dd($id);

        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    } 
}




