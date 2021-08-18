<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Product;
use App\Form\ReviewType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    // /**
    //  * @Route("/review", name="review")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('review/index.html.twig', [
    //         'controller_name' => 'ReviewController',
    //     ]);
    // }

    /**
     * //Pour montrer les infos d'un produit et un formulaire de commentaire permettant d'ajouter des commentaires à ce produit
     * 
     * @Route("/review/{id}", name="review")
     * 
     */
    public function review($id, Request $request, EntityManagerInterface $manager)
    {

        // $order = $this->entityManager->getRepository(OrderDetails::class)->findOneByReference($reference);
        // $order = $this->entityManager->getRepository(OrderDetails::class);


        // On récupère le produit correspondant à l'id sélectionné et apparaissant dans l'URL (= produit qui m'intéresse dans ma commande)
        $orderDetails = $this->getDoctrine()->getRepository(OrderDetails::class)->findOneBy(['id' => $id]);

        
        // dd($orderDetails);

        // $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy([
        //     'id' => $id,
        // ]);
        

        // On récupère les commentaires validés du produit correspondant à l'id sélectionné et apparaissant dans l'URL
        // $commentaires = $this->getDoctrine()->getRepository(Review::class)->findBy(['orderDetails' => $orderDetails, 'status' => "Validé"],['createdAt' => 'desc']);
        $commentaires = $this->getDoctrine()->getRepository(Review::class)->findBy(['orderDetails' => $orderDetails],['createdAt' => 'desc']);
        
        
        
        $commentaireNV = $this->getDoctrine()->getRepository(Review::class)->findBy(['orderDetails' => $orderDetails, 'status' => "Non validé"],['createdAt' => 'desc']);



        $commentaireNull = $this->getDoctrine()->getRepository(Review::class)->findBy(['orderDetails' => $orderDetails, 'status' => ""],['createdAt' => 'desc']);
        // dd($commentaires);
        // die();
       


        if(!$orderDetails){
            throw $this->createNotFoundException("Le produit recherché n'existe pas");
        }

        //Instancier l'entité commentaire
        $comment = new Review();

        // $user = new User();
        // $user = $this->getUser()->getPublicName();
        $user = $this->getUser();
        // dd($user);

        //Créer l'objet formulaire
        $form = $this->createForm(ReviewType::class, $comment);

        //Récupération des données saisies
        $form->handleRequest($request);

        //Vérifier l'envoi du formulaire et si les données sont valides
        if($form->isSubmitted() && $form->isValid()) {

            //Le formulaire a été envoyé et les données sont valides

            $comment->setCreatedAt(new \DateTime())
                    ->setOrderDetails($orderDetails)
                    ->setAuthor($this->getUser()->getPublicName())
                    ->setUser($user)
                    ->setStatus("Non validé")
                    ->setCodeProduct($orderDetails->getIdProduct());
                    // ->setCodeProduct($this->getOrderDetails()->getIdProduct());
                    // ->setCodeProduct($orderDetails)->;

        //On hydrate l'objet en y ajoutant les données  
            $manager->persist($comment);
        //On écrit dans la BDD
            $manager->flush();

            $mail = new Mail();
            $content = "Bonjour ".$user->getFirstname()."<br/>Votre avis nous est précieux et nous vous remercions d'avoir déposé un commentaire à propos de l'achat que vous venez d'effectuer. Toutes nos équipes sont mobilisées pour vous.";
            $mail->send($user->getEmail(), $user->getFirstname(), 'Merci pour votre commentaire !', $content);

            // $this->addFlash(
            //     'success',
            //     "Commentaire envoyé - Merci ! Nous sommes en train de traiter votre commentaire. 
            //     Cela peut prendre quelques heures. Merci de votre patience. 
            //     A l'issu de ce traitement vous retrouverez votre commentaire sur le site."
            // );

            return $this->redirectToRoute('account_order');
        }

        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('review/index.html.twig', [
            'orderDetails' => $orderDetails,
            'form' => $form->createView(),
            'comment' => $comment,
            'commentaires' => $commentaires,
            'commentaireNV' => $commentaireNV,
            'commentaireNull' => $commentaireNull,
            'message' => "Commentaire envoyé - Merci ! Nous sommes en train de traiter votre commentaire. 
            //     Cela peut prendre quelques heures. Merci de votre patience. 
            //     A l'issu de ce traitement vous retrouverez votre commentaire sur le site."
            // 'order' => $order,
        ]);
    }


    /**
     *Permet d'éditer un commentaire pour le modifier
     * 
     *  @Route("/compte/mes-commandes/mes-commentaires/{id}/edit", name="account_comment_edit")
     * @param Review $review
     * @return Response
     */
    public function edit(Review $review, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $comment->setAuthor($this->getUser());
            //$comment->setCreatedAt(new \DateTime());
            // $comment->setUtilisateur($user);

            $manager->persist($review);
            $manager->flush();

            $this->addFlash(
            'success',
            "Le commentaire n°<strong>{$review->getId()} </strong> a été modifié !"
            );

            return $this->redirectToRoute("account_comments");
        }

        return $this->render('account/review_edit.html.twig', [
                'form' => $form->createView()
            ]);
    }
        

    /**
     *Permet de supprimer un commentaire
     * 
     * @Route("/compte/mes-commandes/mes-commentaires/{id}/delete", name="account_comment_delete")
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Review $review, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($review);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire sélectionné a bien été supprimé !"
            );

        return $this->redirectToRoute('account_comments');
    }
}
