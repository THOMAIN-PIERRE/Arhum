<?php

namespace App\Controller;

use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationsController extends AbstractController
{

    /**
     * Affichage la page des conditions générales d'utilisation du site
     * 
     * @Route("/informations", name="cgu")
     */
    public function cgu(StatsService $statsService)
    {
        $bestProducts = $statsService->getProductsStats('DESC');
        $worstProducts = $statsService->getProductsStats('ASC');

        $bestRevenue = $statsService->getRevenueStats('DESC');
        $worstRevenue = $statsService->getRevenueStats('ASC');
        
        
        $displayUsers = $statsService->getUsersStats('ASC');
        

        return $this->render('informations/cgu.html.twig', [
            'bestProducts' => $bestProducts,
            'worstProducts' => $worstProducts,
            'bestRevenue' => $bestRevenue,
            'worstRevenue' => $worstRevenue,
            'displayUsers' => $displayUsers,

        ]);
    }


    /**
     * Affichage des mentions légales du site
     * 
     * @Route("/informations/mentionsLegales", name="mentionsLegales")
     */
    public function mentionsLegales()
    {
       

        return $this->render('informations/mentionsLegales.html.twig', [
            
        ]);
    }


    /**
     * Affichage de la politique de confidentialité du site
     * 
     * @Route("/informations/politiqueConfidentialite", name="politiqueConfidentialite")
     */
    public function politiqueConfidentialite()
    {
       

        return $this->render('informations/politiqueConfidentialite.html.twig', [
            
        ]);
    }
}

