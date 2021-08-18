<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Recipes;
use App\Entity\Recettes;
use App\Form\RecipeType;
use Symfony\Flex\Recipe;
use App\Entity\OutletStore;
use App\Form\ImgRecipeType;
use App\Form\ModifyingRecipeType;
use App\Service\PaginationService;
use App\Repository\ProduitRepository;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DomaineRhumaController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/domaine_rhuma/magasin-usine", name="magasin-usine")
     */
    public function magasin()
    {

        $informations = $this->entityManager->getRepository(OutletStore::class)->findAll();

        return $this->render('domaine_rhuma/magasin-usine.html.twig', [
            'informations' => $informations,   
        ]);
    }

    /**
     * @Route("/domaine_rhuma/environement", name="environnement")
     */
    public function environnement()
    {
        return $this->render('domaine_rhuma/environnement.html.twig', [
            
        ]);
    }


    // /**
    //  * @Route("/domaine_rhuma/recettes", name="recettes")
    //  */
    // public function recette()
    // {
    //     $recettes = $this->entityManager->getRepository(Recipes::class)->findAll();

    //     return $this->render('domaine_rhuma/recettes.html.twig', [
    //             'recettes' => $recettes,
    //     ]);
    // }

    /**
     * Permet d'afficher toutes les recettes stockées en BDD
     * 
     * @Route("/domaine_rhuma/recettes/{page<\d+>?1}", name="recettes")
     */
    public function recette(RecipesRepository $repo, $page, PaginationService $pagination)
    {
        $recettes = $this->entityManager->getRepository(Recipes::class)->findAll();

        $pagination->setEntityClass(Recipes::class)
                   ->setPage($page);

        return $this->render('domaine_rhuma/recettes.html.twig', [
            'recettes' => $recettes,
            'pagination' => $pagination,
        ]);
    }


    /**
    * Permet d'ajouter une recette en BDD
    * 
    * @Route("/domaine_rhuma/recette/ajouter-une-recette", name="domaineRhuma_recipe_add")
    */
    public function add(Request $request)
    {
        // dd($this->getUser());

        // initialisatio d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        $recipe = new Recipes;

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $recipe ->setCreatedAt(new \DateTime())
                    ->setAuthor($this->getUser()->getPublicName())
                    ->setStatus("Non validé");

            //On hydrate l'objet en y ajoutant les données (= on prépare l'ajout en BDD)
            $this->entityManager->persist($recipe);
            //On écrit dans la BDD
            $this->entityManager->flush();

            $notification = "Merci ! nous avons bien reçu votre recette.";
            }
            // else{ 
            //     $notification = "Une erreur s'est produite ! Votre recette n'a pas pu être envoyée. Nous vous invitons à faire un nouvel essai.";
            // }    

            // return $this->redirectToRoute("domaineRhuma_recipe_add");

            // $this->addFlash(
            //     'success',
            //     "Votre recette a bien été envoyée. Vous la retrouverez sur notre site après sa validation par notre équipe de modération."
            // );
            


        return $this->render('domaine_rhuma/add_recipe_form.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
        ] );
    }


    /**
    * Permet d'editer une recette pour la modifier
    * 
    * @Route("/domaine_rhuma/recette/modifier-une-recette/{id}", name="domaineRhuma_recipe_edit")
    */
    public function edit($id, Recipes $recipes,  Request $request)
    {

        $recette = $this->entityManager->getRepository(Recipes::class)->findOneById($id);

        // initialisation d'une variable $notification pour l'affichage de message sur ma page
        $notification = null;

        // $recipe = new Recipes;
        $form = $this->createForm(ModifyingRecipeType::class, $recipes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // $recipe ->setCreatedAt(new \DateTime())
            //         ->setAuthor($this->getUser()->getPublicName())
            //         ->setStatus("Non validé");

            //On hydrate l'objet en y ajoutant les données (= on prépare l'ajout en BDD)
            $this->entityManager->persist($recipes);
            //On écrit dans la BDD
            $this->entityManager->flush();

            $notification = "Votre recette a été modifiée avec succès !";
            }

            // $this->addFlash(
            //     'success',
            //     "Votre recette a bien été envoyée. Retrouvez là sur notre site dès sa validation par notre équipe de modération."
            // );
        

        return $this->render('domaine_rhuma/edit_recipe_form.html.twig', [
            'form' => $form->createView(),
            'recette' => $recette,
            'notification' => $notification,
        ] );
    }


    /**
     * Permet de supprimer une recette
     * 
     * @Route("/domaine_rhuma/recette/supprimer-une-recette/{id}", name="domaineRhuma_recipe_delete")
     */
    public function delete(Recipes $recipes)
    {
        // $recette = $this->entityManager->getRepository(Recipes::class)->findOneById($id);

        // if ($recette && $recette->getUser() == $this->getUser()) {
            $this->entityManager->remove($recipes);
            $this->entityManager->flush();
        // }

        return $this->redirectToRoute('recettes');
    }


        /**
    * Permet d'afficher le formulaire de modification de l'illustration de la recette
    * 
    * @Route("/compte/supprimer-mon-image-recette/{id}", name="domaineRhuma_imgRecipe_edit")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function editImgRecipe($id, Recipes $recipes, Request $request, EntityManagerInterface $manager) {

        $recette = $this->entityManager->getRepository(Recipes::class)->findOneById($id);
        // dd($recette);

        // On place notre image dans une variable $img
        $img = $recette->getImg();
        // dd($img);

        // initialisation d'une variable "$notification" pour l'affichage d'un message sur ma page
        $notification = null;

        // $recipe = $this->getUser();

        $form = $this->createForm(ImgRecipeType::class, $recipes);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Gestion des images :
            // On récupère l'image transmise (nous avons fait le choix de n'avoir qu'une image à gérer)
            // La variable $avatar va contenir ce qui est dans le formulaire au niveau du paramètre avatar et on va chercher les données (getData()).
            $image = $form->get('img')->getData(); 

            // On attribut un nouveau nom de fichier (2 fonctions de nommage aléraoire : md5 et uniqid : 
            // md 5 permet de générer une chaîne de caractère aléatoire et uniqid quand à lui est basé sur le temps
            // // la fonction guess.extension() permet d'aller chercher l'extension de l'image que l'on a téléchargée pour la rajouter à la fin de son nom
            if(!$image) {
            
            }
            else{
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
            }

            // // On copie le fichier dans le dossier uploads grâce à la méthode move()
            // // move() contient 2 paramètres: la destination et le fichier
            $image->move(
            //     // getParameter permet d'aller chercher le paramètre que j'ai déclaré dans mon fichier service.yaml et que j'ai appelé "images_directory"
            //     // le 2ème paramètre est le fichier ($fichier)!
                $this->getParameter('images_directory'), $fichier
            );

            //Voilà, nous avons copié notre image du dossier ou elle était stockée sur un serveur ou notre ordi. 
            // L'étape suivante sera de créer l'enregistrement de cette image dans la BDD (et plus précisémment son nom)

            // On stocke l'image dans l'entité User de la BDD et dans notre dossier 'uploads".
            $img->setImg($fichier);

            $manager->persist($img);
            $manager->flush();


            $notification = "Votre illustration a été modifiée !";
            

            // $this->addFlash(
            //     'sucess',
            //     "Votre profil a été mis à jour !"
            // );

            // return $this->redirectToRoute("account_profile");
        }
    
        return $this->render('domaine_rhuma/imgRecipe_form.html.twig', [
            'form' => $form->createView(),
            'recette' => $recette,
            'notification' => $notification
        ]);
    }



    /**
    * Permet de supprimer l'illustration d'une recette du disque de l'ordi  (cad du dossier uploads ou nous l'avons stocké en lui donnant un nom aléatoire)
    * 
    * @Route("/compte/supprimer-mon-image-recette/{id}", name="domaineRhuma_imgRecipe_delete")
    * IsGranted("ROLE_USER")
    *
    * @return Response
    */
    public function deleteImgRecipe($id, Recipes $recipes, EntityManagerInterface $manager) {

        $recette = $this->entityManager->getRepository(Recipes::class)->findOneById($id);
        // dd($recette);

        // On place notre image dans une variable $img
        $img = $recette->getImg();
        // dd($img);

        // initialisation d'un variable $ notification pour l'affichage de message sur ma page
        $notification = null;

        // $user = $this->getUser();
        // $img = $user->getAvatar();

        $form = $this->createForm(ImgRecipeType::class, $recipes);

        // dd($img);

        //Si on a des images, on va les parcourir
        if($img){
            // Dans service.yaml, on a défini l'image_directory qui mène au fichier uploads qui contient nos images. On va lui attacher le nom de notre image
            $nomImage = $this->getParameter("images_directory"). '/' .$img;
            // Vérifions si nous avons bien le chemin de notre image suivi du nom de l'image
            // dd($nomImage);
        }

        // On vérifie si l'image existe
        if(file_exists($nomImage)){
            // dd($nomImage);
            unlink($nomImage);
        }

        // Apres la suppression de l'image dans uploads, on va réécrire sur l'image présente en BDD et la remplacer par une image d'un avatar neutre
        // $image = $user->setAvatar('e29d5ce22434c6895e856fd36360d66b.png');
        // dd($image);
        // On pousse cet avatar neutre en BDD
        $manager->flush();

        $notification = "Votre avatar a été supprimé !";
 
        return $this->render('account/profile.html.twig', [
            'img' => $img,
            // 'image' => $image,
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }



    /**
     * @Route("/domaine_rhuma/detail-recette{id}", name="detail-recette")
     */
    public function detailRecette($id)
    {
        // $recettes = $this->entityManager->getRepository(Recettes::class)->findAll();

        // $repository = $this->getDoctrine()->getRepository(Produit::class);
        // $produit = $repository->findAll();

        $repo = $this->getDoctrine()->getRepository(Recipes::class);
        $recette = $repo->find($id);

        return $this->render('domaine_rhuma/detail-recette.html.twig', [
            // 'produit' => $produit,
            'recette' => $recette,
        ]);
    }
}

