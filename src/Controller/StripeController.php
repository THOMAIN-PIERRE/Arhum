<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference)
    {
        $products_for_stripe = [];
        // Il faudra indiquer l'adresse de notre vrai domaine de notre site en mode prod afin que Stripe puisse accéder à vos images de produits et les afficher (ex : https://www.maboutique.com/uploads/...)
        $YOUR_DOMAIN = 'http://127.0.0.1:8000'; 

        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        // Si tu ne trouves par order, renvoyer une réponse JSON de type erreur qui concerne mon order
        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        // dd($order->getOrderDetails()->getValues());

        foreach ($order->getOrderDetails()->getValues() as $product){
            // dd($product);
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            $products_for_stripe[] = [
                'price_data'=> [
                    'currency'=> 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/products/".$product_object->getIllustration()],
                    ],
                ],    
                'quantity' => $product->getQuantity(),
            ];
        }

        $products_for_stripe[] = [
            'price_data'=> [
                'currency'=> 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    // Possibilité de rajouter une icône de transporteur (Colissimo, ...). mais pour l'instant cela ne fonctionne pas car on est en mode dev (cad en local)
                    'images' => [$YOUR_DOMAIN],
                ],
            ],    
            'quantity' => 1,
        ];

        // dd($products_for_stripe);

        // Stripe::setApiKey('sk_test_51IadQaFtHAx6LVRSLFp9rxozuISk4kvZoheJkpYi1MsZDsSVXYBnIarQed5Gk1vnMbHW8WANrTVwy8d56AIxhnut00jXuJR0eW');
        // Stripe::setApiKey('sk_test_51IbRaFGSqSKftfeN5I1FItnthsKi8lEUpOYStaxss7cNZ4oaE9eH1oKpgkiiGnGLSuAbNLP6ToXC3zcNTM7GpcIL00NBCVb8PJ');
        Stripe::setApiKey('sk_test_51IfV74C3WNCF4sabgvVJIDQcbPvitEm2pWazWwv7AQ3MTO2ypxNA0UY6a2dIALnrRzN8T0BEzNvVezquejd56WJO00xN3Uhkcy');
        

        // la variable $checkout_session génére un id de sessions pour Stripe
        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
                'payment_method_types' => ['card'],
                'line_items' => [
                    $products_for_stripe
                ],
                'mode' => 'payment',
                //URLs de redirection
                'success_url' => $YOUR_DOMAIN.'/commande/merci/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN.'/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);

        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
