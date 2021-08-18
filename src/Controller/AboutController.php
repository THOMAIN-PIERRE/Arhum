<?php

namespace App\Controller;


use App\Entity\About;
use App\Entity\StatBlock;
use App\Entity\EcoCertification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
   /**
     * @Route("/qui-sommes-nous", name="nous")
     */
    public function qui_sommes_nous()
    {
        // $abouts = $this->entityManager->getRepository(Recipes::class)->findAll();

        $repo = $this->getDoctrine()->getRepository(About::class);
        $abouts = $repo->findAll();
        // dd($abouts);

        // Affichage du Partners Block
        $repo = $this->getDoctrine()->getRepository(EcoCertification::class);
        $ecoCert = $repo->findAll();

        $repo = $this->getDoctrine()->getRepository(StatBlock::class);
        $statBlock = $repo->findAll();


        return $this->render('about/index.html.twig', [
            'ecoCert' => $ecoCert,
            'statBlock' => $statBlock,
            'abouts' => $abouts,
        ]);
    }
}
