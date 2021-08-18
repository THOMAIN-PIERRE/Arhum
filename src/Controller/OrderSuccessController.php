<?php

namespace App\Controller;

use DateTime;
use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId){

        $order =$this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        // Je vérifie si ma commande existe : si l'order n'existe pas ou si le propriétaire de l'order est différent de moi
        if(!$order || $order->getUser() != $this->getUser()){
            // alors tu n'as pas le droit d'accéder à l'order et tu redirige vers la page 'home'
            return $this->redirectToRoute('home');
        }

        // Si le statut de ma commande est "0" alors exécute ce qu'il y a ci-dessous
        if ($order->getState() == 0){
            // Vider la session "cart"
            // Le client a acheté des produits. Il nous faut maintenant vider son panier en prévision d'un prochain achat
            // Attention, ma fonction index ne connait pas cette variable $cart. Je vais donc devoir lui injecter en paramètre de fonction
            $cart->remove();

            // Modifier le statut state de notre commande en le passant à 1 (on ne veut faire ce state vaut 0 initialement)
            $order->setState(1);
            $date = new DateTime();
            $invoiceNumber = $date->format('dmY').'-'.uniqid();
            $order->setInvoiceNumber($invoiceNumber);
            $order->setStatus('Validé');
            $this->entityManager->flush();

            // Envoyer un email au client pour lui confirmer sa commande
            $mail = new Mail();
            $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci de votre commande.<br/><br/>Harum trium sententiarum nulli prorsus assentior. Nec enim illa prima vera est, ut, quem ad modum in se quisque sit, sic in amicum sit animatus. Quam multa enim, quae nostra causa numquam faceremus, facimus causa amicorum! precari ab indigno, supplicare, tum acerbius in aliquem invehi insectarique vehementius, quae in nostris rebus non satis honeste, in amicorum fiunt honestissime; multaeque res sunt in quibus de suis commodis viri boni multa detrahunt detrahique patiuntur, ut iis amici potius quam ipsi fruantur.";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande "Rhuma Sug" est validée !', $content);

        }

        // Pour afficher les infos de la commande à l'utilisateur, on va passer la variable order à TWIG. On passe un tableau d'options à TWIG et on passe la variable $order ! 
        // dd($order);
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}

