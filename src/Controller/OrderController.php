<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Carrier;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{
    private $entityManager;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request)
    {
        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }    

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getuser()
        ]);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()){
        //     dd($form->getData());
        // }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull(),
        ]);
    }


    /**
     * @Route("/commande/liste-des-transporteurs", name="carrier_list")
     */
    public function carrierList()
    {
        $carriers = $this->entityManager->getRepository(Carrier::class)->findAll();

        return $this->render('order/carrier.html.twig', [
            'carriers' => $carriers,
        ]);
    }


    /**
     * Cette fonction add() nous permet de créer notre commande en BDD. Cette fonction fera le traitement et la soumission du formulaire de commande
     * Je préviens le routeur de Symfony de n'accepter que des requêtes des utilisateurs qui viennent d'un POST (= requêtes de type POST). En effet, par défaut Symfoy accepte tous les types de requêtes.
     * 
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request)
    {

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getuser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
        $date = new DateTime();
        // On créé une variable $carriers. On a nos données dans un objet form, on get carriers et j'ai besoin que tu ailles me récupérer les data ( getData() )
        $carriers = $form->get('carriers')->getData();
        // Concernant l'adresse de livraison, je vais construire une grosse de caractère
        // afin de le stoker sous cette forme sans faire de relation
        $delivery = $form->get('addresses')->getData();
        $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
        // .= permet de dire j'ajoute au contenu de la propriété précédente la chaîne de caractère suivante
        $delivery_content .= '<br>'.$delivery->getPhone();
        
        // Ajoute moi le nom de la compagnie si celui-ci est renseigné
        if ($delivery->getCompany()){
            $delivery_content .= '<br>'.$delivery->getCompany();
        }
        $delivery_content .= '<br>'.$delivery->getAddress();
        $delivery_content .= '<br>'.$delivery->getZipCode().' '.$delivery->getCity();
        $delivery_content .= '<br>'.$delivery->getCountry();

        // dd($delivery_content);

        // dd($delivery);
            // dd($form->getData());
            // Enregistrer ma commande (concerne l'entité Order() )
                $order = new Order();
                $reference = $date->format('dmY').'-'.uniqid();
                $order->setReference($reference);
                // Dans ma commande, je vais devoir stocker un user. Cet utilisateur, je le récupère grâce a la méthode get->User() (= setter).
                // En effet, DOCTRINE me permet de stocker des objets et ici comme j'ai une relation entre ma classe Order et ma classe User, je peux passer un objet
                // Ppermet de clier la table User et la table Order en BDD !
                $order->setUser($this->getUser());
                // Je dois stocker la date actuelle
                $order->setCreatedAt($date);
                // J'ai ensuite besoin de stocker le carrierName et le carrierPrice. Pour cela, j'ai besoin d'accéder à l'objet Carriers
                $order->setCarrierName($carriers->getName());
                $order->setCarrierPrice($carriers->getPrice());
                // Je peux maintenant stocker en BDD la chaine de caractère représentant mon adresse que j'ai construite au-dessus
                $order->setDelivery($delivery_content);
                $order->setState(0);
                
                // j'appelle mon entityManager et lui dis que je veux persister mon Order
                $this->entityManager->persist($order);

                // $products_for_stripe = [];
                // $YOUR_DOMAIN = 'http://127.0.0.1:8000';  
                
                

                // Enregistrer mes produits  (concerne l'entité OrderDetails() )
                // Je récupère ma panier grâce a la classe cart et ma méthode getFull()
                // Le orderDetails représente les produits, les prix, les quantités de ce qui a été ajouté au panier par l'utilisateur
                // Je vais demander a ce que pour chaque produit dans mon panier, le système itère et fasse une nouvelle entrée dans orderDetails()
                // Enfin, je veux qu'un lien soit fait entre orderDetails() et order()
                foreach ($cart->getFull() as $product){
                    $orderDetails = new OrderDetails();
                    // Je veux que tu ailles chercher MyOrder
                    // Permet de faire la liaison entre les tables orderDetails et Order
                    $orderDetails->setMyOrder($order);
                    // Je veux que tu ailles chercher le nom de mon produit (attention : je dois aller chercher mon entrée product dans mon array $product)
                    $orderDetails->setProduct($product['product']->getName());
                    // $orderDetails->setProduct($product['product']->getId());
                    $orderDetails->setQuantity($product['quantity']);
                    $orderDetails->setPrice($product['product']->getPrice());
                    $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                    $orderDetails->setIdProduct($product['product']->getId());
                    $orderDetails->setPicture($product['product']->getIllustration());
                    $orderDetails->setContent($product['product']->getConditioning()->getVolume());
                    $orderDetails->setPackage($product['product']->getConditioning()->getContainer());
                    $orderDetails->setScale($product['product']->getCharacteristic()->getDegree());

                    // $orderDetails->setConditioning();

                    // dd($product);
                    // dd($orderDetails);

                    // A ce stade, j'ai fini de construire mes objets. je peux maintenant les passer à Doctrone pour les envoyer, les enregistrer en BDD
                    // Ici, je devrais d'abord sauvegarder l'Oder puis l'OrderDetails puis enfin sauvegarder le tout.
                    // première chose dont on a besoin pour discuter avec Doctrine et stocker des informations d'un "entityManager". On va le construire directement dans notre constructeur comme cela
                    // si on en a besoin dans d'autres fonction de ce controller il ser a notre disposition !

                    // j'appelle mon entityManager et lui dis que je veux persister mon OrderDetails
                    $this->entityManager->persist($orderDetails);

                    // dd($order);

                    // $products_for_stripe[] = [
                    //     'price_data'=> [
                    //         'currency'=> 'eur',
                    //         'unit_amount' => $product['product']->getPrice(),
                    //         'product_data' => [
                    //             'name' => $product['product']->getName(),
                    //             'images' => [$YOUR_DOMAIN."/uploads/".$product['product']->getIllustration()],
                    //         ],
                    //     ],    
                    //     'quantity' => $product['quantity'],
                    // ];

                }

                // dd($products_for_stripe);

                // Je n'ai plus maintenant qu'a flusher le tout (Order et OrderDetails) en BDD
                // La commande est alors enregistrée dans notre BDD sans qu'elle n'ait été vraiment finalisée c'est a dire payée !
                // C'est intéressant car cela nous permettra de filtrer sur le champs is_paid dans la table Order pour voir toutes les commandes 
                // qui n'ont pas été payées et ainsi pouvoir relancer nos utilisateurs en leur reproposant d'acheter ces produits et en les prevenant qu'ils n'ont pas finalisé leur achat.
                // Cela nous offre une vision sur les paniers abandonnés et nous permet de les reproposer au client !
                // On pourra aussi en BDD afficher toutes les commandes abandonnées dans notre backoffice easyAdmin !!!!
                $this->entityManager->flush();

                // Stripe::setApiKey('sk_test_51HylAJE2NhxtV7MmMecLjnULzLB1XZvJXZWmvOC1sVaCtdC1uB6DSphjhdCY24qbV8U2nrgAJ07R67gQ6CznNnrQ00VBG6kXhn');
                // Stripe::setApiKey('sk_test_51IfUuvDbocFhyhf47rinfOhqh1lHrr72irVheGW8WazpHe7UlByBbkhfKlxcjIiZS4LzeY0fozIkPmjtsnYMvRVZ00379Tnajo');

                // $checkout_session = Session::create([
                //         'payment_method_types' => ['card'],
                //         'line_items' => [
                //             $products_for_stripe
                //         ],
                //         'mode' => 'payment',
                //         //URLs de redirection
                //         'success_url' => $YOUR_DOMAIN.'/success.html',
                //         'cancel_url' => $YOUR_DOMAIN.'/cancel.html',
                // ]);
            
                // dump($checkout_session->id);
                // dd($checkout_session);

                // On place le return dans le if pour s'assurer que la vue order/add.html.twig ne sera pas affichée si la personne n'arrive pas avec un post dans cette route.
                // Ansi, seulement si le formulaire est soumis on affichera la route permettant d'aller plus loin dans le processus d'achat
                return $this->render('order/add.html.twig', [
                    'cart' => $cart->getFull(),
                    'carrier' => $carriers,
                    'delivery' => $delivery_content,
                    'reference' => $order->getReference()
                    // 'stripe_checkout_session' => $checkout_session->id
                ]);
    
        }

        // Sinon, s'il n'y a pas de POST (= si un formulaire n'est pas soumis), tu redirige vers la route 'cart'
        return $this->redirectToRoute('cart');
   
    }

}
