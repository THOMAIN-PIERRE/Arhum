<?php
namespace App\Service;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsService {

    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;

    }

    public function statistics(CategoryRepository $categRepository)
    {
        // $categories = $categRepository->findAll();

        // $categName = [];
        // $categColor = [];
        // $categCount = [];

        // foreach($categories as $category){
        //     $categName[] = $category->getName();
        //     $categColor[] = $category->getColor();
        //     $categCount[] = count($category->getProducts());
        // }

        // return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
        //     'categName' => json_encode($categName),
        //     'categColor' => json_encode($categColor),
        //     'categCount' => json_encode($categCount),
        // ]);

            
    }

    // public function getProductsStats($direction){
    //     return $this->manager->createQuery(
    //         'SELECT COUNT(o.product) as produit, o.quantity
    //         FROM App\Entity\OrderDetails o
            
    //         -- GROUP BY p
    //         ORDER BY produit' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }


    // public function getArticlesStats($direction){
    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.username, u.avatar
    //         FROM App\Entity\Comment c
    //         JOIN c.article a
    //         JOIN a.utilisateurs u
    //         GROUP BY a
    //         ORDER BY note ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }




        // Fonctionne !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    // public function getProductsStats(){
    //     return $this->manager->createQuery(
    //         'SELECT COUNT(o.product) as produit
    //         FROM App\Entity\OrderDetails o
    //         -- JOIN c.article a
    //         -- JOIN a.utilisateurs u
    //         -- GROUP BY a
    //         ORDER BY produit '
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }
    
    // Calcul des articles et plus et les moins populaires selon la direction d'affichage (Requête DQL)
    public function getProductsStats($direction){
        return $this->manager->createQuery(
            'SELECT (o.product) as produit, COUNT(o.product) as number, COUNT(o.quantity) as quantity, (SUM(o.total)/100) as prix
            FROM App\Entity\OrderDetails o
            -- JOIN o.order r
            -- JOIN a.utilisateurs u
            GROUP BY produit
            ORDER BY number ' . $direction
        )
        ->setMaxResults(5)
        ->getResult();
    }


    // Calcul des meilleures et des plus mauvaises ventes selon la direction d'affichage (Requête DQL)
    public function getRevenueStats($direction){
        return $this->manager->createQuery(
            'SELECT (o.product) as produit, COUNT(o.product) as number, COUNT(o.quantity) as quantity, (SUM(o.total)/100) as prix
            FROM App\Entity\OrderDetails o
            -- JOIN o.order r
            -- JOIN a.utilisateurs u
            GROUP BY produit
            ORDER BY prix ' . $direction
        )
        ->setMaxResults(5)
        ->getResult();
    }


    // Statistiques des utilisateurs (Requête DQL)
    // public function getUsersStats($direction){
    //     return $this->manager->createQuery(
    //         'SELECT (u.lastname) as nom, u.firstname, u.email, u.createdAt
    //         FROM App\Entity\User u
    //         -- JOIN u.order o
    //         -- JOIN a.utilisateurs u
    //         -- GROUP BY produit
    //         ORDER BY nom ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }

//-------------------------------------------------------------------------------------------------

    // Nombre de commandes par client (Requête DQL)
    public function getUsersStats($direction){
        return $this->manager->createQuery(
            'SELECT Count(o.stripeSessionId) as number, u.firstname, u.lastname, u.email, u.createdAt
            FROM App\Entity\Order o
            JOIN o.user u
           
            -- JOIN a.utilisateurs u
            GROUP BY u
            ORDER BY number ' . $direction
        )
        ->setMaxResults(20)
        ->getResult();
    }




    // Total dépense par client (Requête DQL)
    // public function getUsersStats2($direction){
    //     return $this->manager->createQuery(
    //         'SELECT (SUM(o.total)/100) as spend, Count(r.stripeSessionId) as num, u.firstname, u.lastname, u.email, u.createdAt
    //         FROM App\Entity\OrderDetails o
    //         JOIN o.myOrder r
    //         JOIN r.user u
           
    //         -- JOIN a.utilisateurs u
    //         GROUP BY u
    //         ORDER BY spend ' . $direction
    //     )
    //     ->setMaxResults(20)
    //     ->getResult();
    // }

    // Total dépensé par client (Requête DQL)
    public function getUsersStats2($direction){
        return $this->manager->createQuery(
            'SELECT (o.myOrder) as commande, (SUM(o.total)/100) as depense, u.firstname, u.lastname, u.createdAt
            FROM App\Entity\OrderDetails o
            JOIN o.myOrder r
            JOIN r.user u
            GROUP BY commande
            ORDER BY commande ' . $direction
        )
        // ->setMaxResults(20)
        ->getResult();
    }


    // public function getHomeCommentsStatsPerPerson($direction){
    //     return $this->manager->createQuery(
    //         "SELECT Count(c.Author) as num, u.avatar, u.username
    //         FROM App\Entity\Comment c
    //         JOIN c.utilisateur u
    //         WHERE c.status = 'Validé'
    //         GROUP BY u
    //         ORDER BY num " . $direction
           
    //     )
    //     ->setMaxResults(3)
    //     ->getResult();
    // }

//---------------------------------------------------------------------------------------------------------------------

    // Requêtes pour afficher toutes les commandes converties (=payées) passées aujourd'hui (Requête DQL)
    public function todayOrders($direction){
        return $this->manager->createQuery(
            'SELECT o.createdAt, o.carrierName, o.reference, o.stripeSessionId, o.delivery
            FROM App\Entity\Order o
            WHERE o.createdAt >= current_Date()
            -- JOIN u.order o
            -- JOIN a.utilisateurs u
            -- GROUP BY produit
            ORDER BY o.createdAt ' . $direction
        )
        ->setMaxResults(5)
        ->getResult();
    }


    // public function getCountOrders(){
    //     return $this->manager->createQuery(
    //         "SELECT Count(o.stripeSessionId)
    //         FROM App\Entity\Order o"
    //     )
        
    //     ->getScalarResult();
    
    // }

    // Nombre de commandes par client (Requête DQL)
    public function getCountOrdersByUser(){
        return $this->manager->createQuery(
            'SELECT Count(o.stripeSessionId) as num, u.firstname, u.lastname, u.email, u.createdAt
            FROM App\Entity\Order o
            -- JOIN o.user u
           
            -- -- JOIN a.utilisateurs u
            -- GROUP BY u
            ORDER BY num ' 
        );
        // ->setMaxResults(20)
        // ->getScalarResult();
    }


    // /**
    // * findSuccessOrders()
    // *permet d'afficher les commandes dans l'espace membre de l'utilisateur
    // */
    // public function getNumberOfNullPayment()
    // {
    //     return $this->manager->createQuery(
    //         "SELECT Count(o.stripeSessionId)
    //         FROM App\Entity\Order o"
    //         // -- Where('o.stripeSessionId != null')"
    //         // -- AND Where('o.user = $user')
    //         // -- ->andWhere('o.user = :user')
    //         // -- set Parameter('user', $user)
    //         // -- ->orderBy('o.id', 'DESC')
    //         // -- ->getQuery()
    //     )
    //         ->getScalarResult();
    // }


    // public function getCountInProgressOrdersByUser(){
    //     return $this->manager->createQuery(
    //         "SELECT Count(o.stripeSessionId)
    //         FROM App\Entity\Order o
    //         WHERE o.state > 0
    //         AND o.state < 4"
    //     )
        
    //     ->getSingleScalarResult();
    
    // }


    // public function getCountAddresses(){
    //     return $this->manager->createQuery(
    //         "SELECT Count(a.address)
    //         FROM App\Entity\Address a"
    //     )
        
    //     ->getSingleScalarResult();
    
    // }
    

    // Total dépensé par commande (Requête DQL)
    public function getTotalAmountSpent(){
        return $this->manager->createQuery(
            'SELECT (o.myOrder) as commande, (SUM(o.total)/100) as depense, u.firstname, u.lastname, u.createdAt
            FROM App\Entity\OrderDetails o
            JOIN o.myOrder r
            JOIN r.user u 
            GROUP BY commande
            ORDER BY commande '
        )
        // ->setMaxResults(20)
        ->getResult();
    }


    // Total dépensé par commande (Requête DQL)
    public function getTotalAmount(){
        return $this->manager->createQuery(
            'SELECT (SUM(o.total)/100) as depense
            FROM App\Entity\OrderDetails o'   
        )
        // ->setMaxResults(20)
        ->getScalarResult();
    }


    // Requêtes pour afficher toutes les commandes (converties + non converties) passées aujourd'hui (Requête DQL)
    // public function todayNotConvertedOrders($direction){
    //     return $this->manager->createQuery(
    //         'SELECT o.createdAt, o.carrierName, o.reference, o.stripeSessionId
    //         FROM App\Entity\Order o
    //         WHERE o.createdAt > current_Date()
    //         -- JOIN u.order o
    //         -- JOIN a.utilisateurs u
    //         -- GROUP BY produit
    //         ORDER BY o.createdAt ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }



    


     // Statistiques des utilisateurs2
    //  public function getUsersStats2($direction){
    //     return $this->manager->createQuery(
    //         'SELECT (u.lastname) as nom, u.firstname, u.email, u.createdAt, COUNT(o.userId) as nbCommand
    //         FROM App\Entity\User u
    //         -- JOIN u.order o
    //         -- JOIN a.utilisateurs u
    //         -- GROUP BY produit
    //         ORDER BY nom ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }


    // Statistiques des utilisateurs3
    // public function getUsersStats3($direction){
    //     return $this->manager->createQuery(
    //         'SELECT (o.userId) as Id, o.stripeSessionId, , COUNT(o.stripeSessionId) as convertedOrders,
    //         FROM App\Entity\Order o
    //         JOIN o.user u
    //         -- JOIN a.utilisateurs u
    //         -- GROUP BY produit
    //         ORDER BY Id ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }

    
}