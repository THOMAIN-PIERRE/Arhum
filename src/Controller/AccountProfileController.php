<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\AvatarType;
use App\Form\PseudoType;
use App\Form\ProfileType;
use App\Form\IdentityType;
use App\Form\EmailProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Pour afficher les différents éléments du profil utilisateur
     * 
     * @Route("/compte/profil", name="account_profile")
     */
    public function index()
    {
        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        return $this->render('account/profile.html.twig', [
            'notification' => $notification,
        ]);
    }

    // /**
    // * Permet d'afficher le formulaire d'ajout d'un avatar et d'une date de naissance au profil
    // * 
    // * @Route("/compte/renseigner-mon-profil", name="account_profile_add")
    // * IsGranted("ROLE_USER")
    // *
    // * @return Response
    // */
    // public function addProfile(Request $request, EntityManagerInterface $manager) {

    //     $users = $this->getUser();

    //     $form = $this->createForm(ProfileType::class, $users);

    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {
    //         // Gestion des images :
    //         // On récupère l'image transmise (nous avons fait le choix de n'avoir qu'une image à gérer)
    //         // La variable $avatar va contenir ce qui est dans le formulaire au niveau du paramètre avatar et on va chercher les données (getData()).
    //         // $avatar = $form->get('avatar')->getData(); 

    //         // On attribut un nouveau nom de fichier (2 fonctions de nommage aléraoire : md5 et uniqid : 
    //         // md 5 permet de générer une chaîne de caractère aléatoire et uniqid quand à lui est basé sur le temps
    //         // la fonction guess.extension() permet d'aller chercher l'extension de l'image que l'on a téléchargée pour la rajouter à la fin de son nom
    //         // $fichier = md5(uniqid()).'.'.$avatar->guessExtension();

    //         // On copie le fichier dans le dossier uploads grâce à la méthode move()
    //         // move() contient 2 paramètres: la destination et le fichier
    //         // $avatar->move(
    //             // getParameter permet d'aller chercher le paramètre que j'ai déclaré dans mon fichier service.yaml et que j'ai appelé "images_directory"
    //             // le 2ème paramètre est le fichier ($fichier)!
    //             // $this->getParameter('images_directory'), $fichier
    //         // );

    //         //Voilà, nous avons copié notre image du dossier ou elle était stockée sur un serveur ou notre ordi. 
    //         // L'étape suivante sera de créer l'enregistrement de cette image dans la BDD (et plus précisémment son nom)

    //         // On stocke l'image dans l'entité User de la BDD et dans notre dossier 'uploads".
    //         // $users->setAvatar($fichier);

    //         $manager->persist($users);
    //         $manager->flush();

    //         $this->addFlash(
    //             'sucess',
    //             "Votre profil a été mis à jour !"
    //         );

    //         return $this->redirectToRoute("account_profile");
    //     }

    //     return $this->render('account/profile_form.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }


    /**
    * Permet d'afficher le formulaire de modification du profil
    * 
    * @Route("/compte/{id}/modifier-mon-profil", name="account_profile_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editProfile(Request $request, EntityManagerInterface $manager) {

        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $users = $this->getUser();

        $form = $this->createForm(PseudoType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Vérification que le pseudo n'est pas déjà existant en BDD
            $search_pseudo = $this->entityManager->getRepository(User::class)->findOneByPublicName($users->getPublicName());

            if (!$search_pseudo){
                $pseudo = $users->getPublicName();
    
                $users-> setPublicName($pseudo);


            $manager->persist($users);
            $manager->flush();


            $notification = "Votre pseudo a été modifié !";
            }else{ 
                $notification = "Veuillez choisir un autre pseudo, celui-ci est déjà prit !";
            }    

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
    

        return $this->render('account/pseudo_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }



    // /*
    // * Permet de gérer la suppression d'une image !
    // * La méthode nous permet de récupérer une image et de la supprimer. 
    // * ATTENTION : on va sécuriser ce formulaire avec un token de sécurisation (csrf_token) pour éviter que cete route soit utilisée par n'importe qui !
    // * 
    // * @Route("/compte/supprimer/user/{avatar}", name="account_profileAvatar_delete", methods={"DELETE"})
    // * IsGranted("ROLE_USER")
    // *
    // * @return Response
    // */
    // public function deleteImage(User $user, Request $request, EntityManagerInterface $manager) {

    //     $data = json_decode($request->getContent(), true);

    //     // On vérifie si le token est valide (isCsrfTokenValid = méthode qui valide les Token)
    //     if($this->isCsrfTokenValid('delete', $data['_token'])){
    //         // On récupère le nom de l'image
    //         $nomImg = $user->getAvatar();
    //         // On supprime le fichier en allant la chercher dans le dossier uploads ou elle est stockée
    //         unlink($this->getParameter('images_directory').'/'.$nomImg);
    
    //         // On supprime l'entrée de la base de donnée
    //         $em = $this->getDoctrine()->getManager();
    //         $em->remove($nomImg);
    //         $em->flush();
    
    //         // On répond en json
    //         return new JsonResponse(['success' => 1]);
    //     }else{
    //         //Si le token n'est pas valide on dira
    //         return new JsonResponse(['error' => 'Token Invalide'], 400);
    //     }
    // }  


    /**
    * to display the avatar modification form
    * 
    * @Route("/compte/{id}/modifier-mon-avatar", name="account_avatar_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editAvatarProfile(Request $request, EntityManagerInterface $manager) {

        // initialization of a $notification variable to notify user at the end
        $notification = null;

        $users = $this->getUser();

        $form = $this->createForm(AvatarType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Gestion des images :
            // On récupère l'image transmise (nous avons fait le choix de n'avoir qu'une image à gérer)
            // La variable $avatar va contenir ce qui est dans le formulaire au niveau du paramètre avatar et on va chercher les données (getData()).
            // Images mmanagement:
            // We retrieve the transmitted picture (we have chosen to have only one image to manage)
            // variable $avatar will contain what is in the form at the level of the avatar parameter and we will get the data (getData ()).
            $avatar = $form->get('avatar')->getData(); 

            // On attribut un nouveau nom de fichier (2 fonctions de nommage aléatoire : md5 et uniqid : 
            // md5 permet de générer une chaîne de caractère aléatoire et uniqid quand à lui est basé sur le temps
            // // la fonction guess.extension() permet d'aller chercher l'extension de l'image que l'on a téléchargée pour la rajouter à la fin de son nom
            if(!$avatar) {
            
            }
            else{
            $fichier = md5(uniqid()).'.'.$avatar->guessExtension();
            }

            // // On copie le fichier dans le dossier uploads grâce à la méthode move()
            // // move() contient 2 paramètres: la destination et le fichier
            $avatar->move(
            //     // getParameter permet d'aller chercher le paramètre que j'ai déclaré dans mon fichier service.yaml et que j'ai appelé "images_directory"
            //     // le 2ème paramètre est le fichier ($fichier)!
                $this->getParameter('images_directory'), $fichier
            );

            //Voilà, nous avons copié notre image du dossier ou elle était stockée sur un serveur ou notre ordi. 
            // L'étape suivante sera de créer l'enregistrement de cette image dans la BDD (et plus précisémment son nom)

            // On stocke l'image dans l'entité User de la BDD et le fichier uploads.
            $users->setAvatar($fichier);

            $manager->persist($users);
            $manager->flush();


            $notification = "Votre avatar a été modifié !";
            

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
        return $this->render('account/avatar_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }



    /**
    * Permet de supprimer un avatar du disque de l'ordi  (cad du dossier uploads ou nous l'avons stocké en lui donnant un nom aléatoire)
    * 
    * @Route("/compte/supprimer-mon-avatar/{id}", name="account_avatar_delete")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function deleteAvatarProfile(User $user, EntityManagerInterface $manager) {

        // initialisation d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $user = $this->getUser();
        $img = $user->getAvatar();

        $form = $this->createForm(AvatarType::class, $user);

        // dd($img);

        //Si on a des images, on va les parcourir
        if($img){
            // Dans service.yaml, on a défini l'image_directory qui mène au fichier uploads qui contient nos images. On va lui attacher le nom de notre image
            $nomImage = $this->getParameter("images_directory"). '/' .$img;
            // dd($nomImage);
        }

        // On vérifie si l'image existe
        if(file_exists($nomImage)){
            // dd($nomImage);
            unlink($nomImage);
        }

        // Apres la suppression de l'image dans uploads, on va réécrire sur l'image présente en BDD et la remplacer par une image d'un avatar neutre
        $image = $user->setAvatar('e29d5ce22434c6895e856fd36360d66b.png');
        // dd($image);
        // On pousse cet avatar neutre en BDD
        $manager->flush();

        $notification = "Votre avatar a été supprimé !";
 
        return $this->render('account/profile.html.twig', [
            'img' => $img,
            'image' => $image,
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }


    /**
    * Permet d'afficher le formulaire de modification de son pseudo
    * 
    * @Route("/compte/{id}/modifier-mon-pseudo", name="account_pseudo_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editPseudoProfile(Request $request, EntityManagerInterface $manager) {

        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $users = $this->getUser();

        $form = $this->createForm(PseudoType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Vérification que le pseudo n'est pas déjà existant en BDD
            $search_pseudo = $this->entityManager->getRepository(User::class)->findOneByPublicName($users->getPublicName());

            if (!$search_pseudo){
                $pseudo = $users->getPublicName();
    
                $users-> setPublicName($pseudo);


            $manager->persist($users);
            $manager->flush();


            $notification = "Votre pseudo a été modifié !";
            }else{ 
                $notification = "Veuillez choisir un autre pseudo, celui-ci est déjà prit !";
            }    

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
    

        return $this->render('account/pseudo_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }


    /**
    * Permet d'afficher le formulaire de modification de son email
    * 
    * @Route("/compte/{id}/modifier-mon-email", name="account_email_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editEmailProfile(Request $request, EntityManagerInterface $manager) {

        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $users = $this->getUser();

        $form = $this->createForm(EmailProfileType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($users);
            $manager->flush();


            $notification = "Votre email a été modifié !";
            

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
    

        return $this->render('account/email_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }


    /**
    * Permet d'afficher le formulaire de modification de ses infos d'état civil
    * 
    * @Route("/compte/{id}/modifier-mon-identite", name="account_identity_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editIdentityProfile(Request $request, EntityManagerInterface $manager) {

        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $users = $this->getUser();

        $form = $this->createForm(IdentityType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($users);
            $manager->flush();


            $notification = "Votre état civil a été modifié !";
            

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
    

        return $this->render('account/identity_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
       
}
