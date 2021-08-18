<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class Cart
{
    //Je vais avoir besoin de la session interface au sein de ma classe cart(). Je vais donc avoir besoin d'une variable $session que je dois construire (__construct)
    private $session;
    private $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        //J'ai injecté la sesion interface dans le __construct et je lui ai donné la variable $session (= je stocke ma session interface dans la variable $session).
        //Pour rendre cela accessible au sein de ma classe je dois écrire session = $session. 
        //Une fois que cela est fait, je peux tranquillement utiliser ma session interface au sein de ma fonction add() 
        $this->session = $session;
        $this->entityManager = $entityManager;
    }
    
    /**
    *Fonction permettant d'ajouter des produits ou des quantités au panier
    *
    *@var string
    */
    public function add($id)
    {
        //On va utiliser la session interface pour ajouter des produits dans mon panier
        //Dans une variable $cart, je stocke le panier contenu dans ma session. 
        //J'utilise le $this pour aller chercher la session que j'ai déclarée au niveau de mon constructeur
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
            
    }

    /**
    * Permet de récupérer le panier
    */
    public function get()
    {
        return $this->session->get('cart');
    }

    // /**
    // * Permet de récupérer le montant total du panier
    // */
    // public function totalRevenue()
    // {
    //     return $this->session->getTotal('cart');
    // }

    /**
    * Permet de supprimer complètement le panier
    */
    public function remove()
    {
        return $this->session->remove('cart');
    }

    /**
    * Permet de supprimer définitivement un produit du panier
    */
    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

        unset ($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    /**
    *Fonction permettant d'enlever des quantités d'un produit au panier
    *
    *@var string
    */
    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1){
            $cart[$id]--;
        }else{
            unset ($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    /**
    * Cette fonction me renvoie mon panier complet 
    *@var string
    */
    public function getFull()
    {

        $cartComplete = [];

        if ($this->get()){

        foreach($this->get() as $id => $quantity) {

            $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

            if (!$product_object){
                $this->delete($id);
                continue;
            }

            $cartComplete[] = [
                'product' => $product_object,
                'quantity' => $quantity,
            ];
            // dd($cartComplete);
        }
    }
      return $cartComplete;
    }
}