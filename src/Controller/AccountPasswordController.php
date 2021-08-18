<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/modifier-mon-mot-de-passe ", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $notification = null; //on initialise une variable notification à null

        $user = $this->getuser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $old_pwd = $form->get('old_password')->getData();

            // dd($old_pwd);

            if($encoder->ispasswordvalid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd);

                $user->setPassword($password);
                // $this->entityManager->persist($user); // persist = fige la donnée et prépare la à être créé en BDD (= création de l'entité). Donc il n'est pas nécessaire de l'ajouter en cas de modification de donnée
                $this->entityManager->flush();

                $notification = "Votre mot de passe à bien été mise à jour"; // d le pwd a été correctement mis à jour, on affichera ce message. Ne pas oublier de passer cette variable à la vue (cad à Twig) !
            }else{
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification // la variable sera affichée si elle est différente de null
        ]);
    }
}

