<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    // /**
    //  * @Route("/partner", name="partner")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('partner/index.html.twig', [
    //         'controller_name' => 'PartnerController',
    //     ]);
    // }


    /**
     * Route permattant d'affichier au client le récapitulatif de son panier
     * 
     * @Route("/mon-panier", name="partners")
     */
    public function index()
    {
        
        $partners = $this->entityManager->getRepository(Partners::class)->findAll();


        return $this->render('partner/index.html.twig',[
            'partners' => $partners

        ]);
    }    
}

