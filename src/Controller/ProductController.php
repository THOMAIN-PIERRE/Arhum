<?php

namespace App\Controller;


use App\Classe\Search;
use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Partners;
use App\Form\SearchType;
use App\Classe\SearchData;
use App\Form\CriteriaType;
use App\Entity\OrderDetails;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ContainerN7pYpvv\getProductControllerService;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(ProductRepository $repository, Request $request)
    {
        $search = new Search();
        $search->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);

        // [$min, $max] = $repository->findMinMax($search);

        $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);

        $repo = $this->getDoctrine()->getRepository(Partners::class);
        $partners = $repo->findAll();


        // $product = $this->entityManager->getRepository(Product::class)->$this->getId();
        // $commentaires = $this->getDoctrine()->getRepository(Review::class)->findBy(['codeProduct' => $product, 'status' => "Validé"]);


        // dd($products);


        // if ($form->isSubmitted() && $form->isValid()){
        //     $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        //     // dd($search);
        // }else{
        //     $products = $this->entityManager->getRepository(Product::class)->findAll();
        // }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'partners' => $partners,
            // 'commentaires' => $commentaires,
            // 'min' => $min,
            // 'max' => $max,
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug, Request $request, SessionInterface $session)
    {

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);

        // dd($product);


        // $form = $this->createForm(CriteriaType::class);

        // $form->handleRequest($request);


        $repo = $this->getDoctrine()->getRepository(Partners::class);
        $partners = $repo->findAll();


        if(!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products,
            'partners' => $partners,

            // 'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/detail{id}", name="detail")
     */
    public function detail_produit($id)
    {
        

        $repo = $this->getDoctrine()->getRepository(Product::class);
        $product = $repo->find($id);

        return $this->render('product/single_product.html.twig', [
            'product' => $product
        ]);
    }


    /**
     * @Route("/chercher", name="chercher")
     */

    //  chercher un produit par son nom
    public function chercher(request $request)
    {
        
        // récupérer l'input chercher
        $string=$request->get('chercher');

        $repo = $this->getDoctrine()->getManager();
        $product = $repo->getRepository(Product::class)->findByString("%".$string."%");

        return $this->render('product/chercher.html.twig',[
            'products' => $product,
            'string' => $string,
            'message' => 'Nous n\'avons trouvé aucun produit en lien avec votre recherche !'
        ]);
    }



    // /**
    //  * // Pour montrer les évaluations client d'un produit
    //  * 
    //  * @Route("/produit/{id}", name="product_evaluation_show")
    //  * 
    //  */
    // public function show_evaluation($idProduct, Request $request, EntityManagerInterface $manager)
    // {
    //     // On récupère le produit correspondant à l'id sélectionné
    //     $product = $this->getDoctrine()->getRepository(OrderDetails::class)->findOneBy(['idProduct' => $idProduct]);

    //     // $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy([
    //     //     'id' => $id,
    //     // ]);
        

    //     // On récupère les commentaires validés du produit
    //     $comments = $this->getDoctrine()->getRepository(Review::class)->findBy(['product' => $product, 'status' => "Validé"],['created_at' => 'desc']);
    //     // dump($comment);
    //     // die();
       

    //     if(!$product){
    //         throw $this->createNotFoundException("Le produit recherché n'existe pas");
    //     }


    //     $repo = $this->getDoctrine()->getRepository(Article::class);

    //     $article = $repo->find($id);

    //     return $this->render('product/evaluation.html.twig', [
    //         'product' => $product,
    //         'comment' => $comments,
    //     ]);
    // }



    /**
     * //Pour montrer les infos d'un produit et un formulaire de commentaire permettant d'ajouter des commentaires à ce produit
     * 
     * @Route("/evaluation/{id}", name="evaluation")
     * 
     */
    public function showComment($id, Request $request, EntityManagerInterface $manager)
    {
        // On récupère l'article correspondant à l'id sélectionné
        // $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['id' => $id]);

        $product = $this->entityManager->getRepository(Product::class)->findOneById($id);
        // dd($product);

        // $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy([
        //     'id' => $id,
        // ]);
        

        // On récupère les commentaires validés de l'article
        // $commentaires = $this->getDoctrine()->getRepository(Review::class)->findBy(['codeProduct' => $product, 'status' => "Validé"],['createdAt' => 'desc']);
        $commentaires = $this->getDoctrine()->getRepository(Review::class)->findBy(['codeProduct' => $product, 'status' => "Validé"],['createdAt' => 'desc']);
        // dd($commentaires);
        // die();
       


        if(!$product){
            throw $this->createNotFoundException("Le produit recherché n'existe pas");
        }

        // //Instancier l'entité commentaire
        // $comment = new Review();

        // $user = $this->getUser();


        // //Créer l'objet formulaire
        // $form = $this->createForm(ReviewType::class, $comment);

        // //Récupération des données saisies
        // $form->handleRequest($request);

        // //Vérifier l'envoi du formulaire et si les données sont valides
        // if($form->isSubmitted() && $form->isValid()) {

        //     //Le formulaire a été envoyé et les données sont valides

        //     $comment->setProduct($product)
        //             ->setCreatedAt(new \DateTime())
        //             ->setAuthor($this->getUser()->getPublicName())
        //             ->setUser($user)
        //             ->setStatus("Non validé");


        // //On hydrate l'objet en y ajoutant les données  
        //     $manager->persist($comment);
        // //On écrit dans la BDD
        //     $manager->flush();

        //     $this->addFlash(
        //         'success',
        //         "Commentaire envoyé - Merci ! Nous sommes en train de traiter votre commentaire. 
        //         Cela peut prendre quelques heures. Merci de votre patience. 
        //         A l'issu de ce traitement vous retrouverez votre commentaire sur le site."
        //     );
        // }

        // $repo = $this->getDoctrine()->getRepository(Product::class);

        // $product = $repo->find($id);

        return $this->render('product/evaluation.html.twig', [
            'product' => $product,
            // 'form' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

}

