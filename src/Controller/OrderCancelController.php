<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_cancel")
     */
    public function index($stripeSessionId)
    {
        // On va aller chercher la commande désirée dans la BDD
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        // On vérifie l'existence de la commande et si je suis bien le propriétaire de la commande
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        // Envoyer un email a notre utilisateur pour lui signifier l'échec du paiement
        $mail = new Mail();
        $content = "Attention ".$order->getUser()->getFirstname()."<br/>Il semblerait que vous avez procédé au paiement d'une commande mais celui-ci a échoué !<br/><br/>Harum trium sententiarum nulli prorsus assentior. Nec enim illa prima vera est, ut, quem ad modum in se quisque sit, sic in amicum sit animatus. Quam multa enim, quae nostra causa numquam faceremus, facimus causa amicorum! precari ab indigno, supplicare, tum acerbius in aliquem invehi insectarique vehementius, quae in nostris rebus non satis honeste, in amicorum fiunt honestissime; multaeque res sunt in quibus de suis commodis viri boni multa detrahunt detrahique patiuntur, ut iis amici potius quam ipsi fruantur.";
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Echec du paiement de la commande', $content);

        // On passe un tableau d'option à la vue TWIG pour lui envoyer la commande concernée 
        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}

