<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\StatsService;
use App\Repository\OrderRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(CategoryRepository $categRepository, OrderRepository $orderRepository, StatsService $statsService): Response
    {
        // On va chercher toutes les catégories
        $categories = $categRepository->findAll();

        // On apporte les infos dont a besoin mon graphique
        $categName = [];
        $categColor = [];
        $categCount = [];

        // Je vais boucler sur toutes mes categories et j'appelle category
        foreach($categories as $category){
            // Puis je rempli chacune des variables avec la catégorie actuelle 
            $categName[] = $category->getName();
            $categColor[] = $category->getColorChart();
            $categCount[] = count($category->getProducts()); // count() permet de calculer la taille d'un objet
        }




        // On va chercher le nombre de commandes passées par date
        // $commandes = $orderRepository-> countByDate();
        $commandes = $orderRepository-> countByDate();

        // dd($commandes);

        // On doit là aussi préparer nos données pour les séparer tel qu'attendu par chartJS
        $dates = [];
        $commandesCount = [];

        foreach($commandes as $commande){
            $dates[] = $commande['dateCommande'];
            $commandesCount[] = $commande['convertedOrders'];
        }



        // On va chercher le nombre de commandes passées par date
        // $commandes2 = $orderRepository-> countByCarrier();

        // dd($commandes);

        // On doit là aussi préparer nos données pour les séparer tel qu'attendu par chartJS
        // $carrier = [];
        // $commandesConverted = [];

        // foreach($commandes2 as $commande){
        //     $carrier[] = $commande['carrierCommand'];
        //     $commandesConverted[] = $commande['convertedOrders'];
        // }


        
        $bestProducts = $statsService->getProductsStats('DESC');
        $worstProducts = $statsService->getProductsStats('ASC');
        $bestRevenue = $statsService->getRevenueStats('DESC');
        $worstRevenue = $statsService->getRevenueStats('ASC');
        $displayUsers = $statsService->getUsersStats('DESC');
        $displayUsers2 = $statsService->getUsersStats2('ASC');
        $todayOrders = $statsService->todayOrders('DESC');
        // $displayUsers3 = $statsService->getUsersStats3('ASC');

        $totalAmount = $statsService->getTotalAmount();
        // $countOrders = $statsService->getCountOrders();

        $nbOfOrders = $statsService->getCountOrdersByUser();


        return $this->render('dashboard/stats.html.twig', [
            //Toutes ces infos que j'ai mises en forme pour mon graphique je vais devoir les envoyer à mon TWIG en JSON !
            // (parce que dans la doc JS CHART ce sont de tableau JSON qui sont demandés)
            'categName' => json_encode($categName),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),

            'dates' => json_encode($dates),
            'commandesCount' => json_encode($commandesCount),

            // 'carrier' => json_encode($carrier),
            // 'commandesConverted' => json_encode($commandesConverted),

            'bestProducts' => $bestProducts,
            'worstProducts' => $worstProducts,
            'bestRevenue' => $bestRevenue,
            'worstRevenue' => $worstRevenue,
            'displayUsers' => $displayUsers,
            'displayUsers2' => $displayUsers2,
            'todayOrders' => $todayOrders,
            'totalAmount' => $totalAmount,
            // 'countOrders' => $countOrders,
            'nbOfOrders' => $nbOfOrders,
            // 'displayUsers3' => $displayUsers3,
        ]);
    }


    // /**
    //  * @Route("/dashboard-utils", name="utils")
    //  */
    // public function utils(StatsService $statsService): Response
    // {

    //     $bestProducts = $statsService->getProductsStats('DESC');
    //     $worstProducts = $statsService->getProductsStats('ASC');

    //     $bestRevenue = $statsService->getRevenueStats('DESC');
    //     $worstRevenue = $statsService->getRevenueStats('ASC');
        
        
    //     $displayUsers = $statsService->getUsersStats('ASC');

    //     return $this->render('dashboard/utils.html.twig', [
    //         'bestProducts' => $bestProducts,
    //         'worstProducts' => $worstProducts,
    //         'bestRevenue' => $bestRevenue,
    //         'worstRevenue' => $worstRevenue,
    //         'displayUsers' => $displayUsers,
    //     ]);
    // }
}

