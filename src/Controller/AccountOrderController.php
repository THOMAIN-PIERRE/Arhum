<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Order;
use App\Entity\Address;
use App\Service\StatsService;
use App\Service\PaginationService;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AccountOrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Pour afficher toutes les commandes d'un utilisateur
     * 
     * @Route("/compte/mes-commandes/{page<\d+>?1}", name="account_order")
     */
    public function index(OrderRepository $repo, $page, PaginationService $pagination)
    {

        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getuser());

        $pagination->setEntityClass(Order::class)
                   ->setPage($page);


        // dd($orders);

        // $countOrders = $this->entityManager->getRepository(Order::class)->findNbSuccessOrders($this->getuser());


        // $user = $this->getuser();

        // $commandes = $orderRepository->findAll();

        // $commandesCount[] = count($commandes->getStripeSessionId($user));



        // $nbOfOrders = $this->entityManager->getRepository(Order::class)->findNumberOfSuccessOrders($this->getuser());
        // $nbOfOrders = $statsService->getNumberOfSuccessOrders();

        // $nbOfOrders = $statsService->getCountOrdersByUser($this->getuser());
        // $nbOfInProgressOrder = $statsService->getCountInProgressOrdersByUser();
        
        // $totalAmountSpent = $statsService->getTotalAmountSpent();

        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'pagination' => $pagination,
            // 'countOrders' => $countOrders,
            // 'commandes' => $commandes,
            // 'nbOfOrders' => $nbOfOrders,
            // 'nbOfInProgressOrder' => $nbOfInProgressOrder,
        ]);
    }

    /**
     * Pour afficher une commande précise d'un utilisateur
     * 
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     */
    public function show($reference)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/invoice/{reference}", name="account_order_invoice_show")
     */
    public function detail($reference)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_order');
        }

        // return $this->render('account/order_invoice_show.html.twig', [
        //     'order' => $order,
        // ]);

        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('account/order_invoice_show.html.twig', [
            'order' => $order,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'facture'. $order->getReference() .'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }
    


    // /**
    //  * @Route("/compte/mes-commandes/invoice/download/{reference}", name="invoice_download")
    //  */
    // public function InvoiceDownload($reference)
    // {

    //     $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

    //     if (!$order || $order->getUser() != $this->getUser()){
    //         return $this->redirectToRoute('account_order');
    //     }


    //     // On définit les options du PDF
    //     $pdfOptions = new Options();
    //     // Police par défaut
    //     $pdfOptions->set('defaultFont', 'Arial');
    //     $pdfOptions->setIsRemoteEnabled(true);

    //     // On instancie Dompdf
    //     $dompdf = new Dompdf($pdfOptions);
    //     $context = stream_context_create([
    //         'ssl' => [
    //             'verify_peer' => FALSE,
    //             'verify_peer_name' => FALSE,
    //             'allow_self_signed' => TRUE
    //         ]
    //     ]);
    //     $dompdf->setHttpContext($context);

    //     // On génère le html
    //     $html = $this->renderView('account/order_invoice_download.html.twig', [
    //         'order' => $order,
    //     ]);

    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();

    //     // On génère un nom de fichier
    //     $fichier = 'facture'. $order->getReference() .'.pdf';

    //     // On envoie le PDF au navigateur
    //     $dompdf->stream($fichier, [
    //         'Attachment' => true
    //     ]);

    //     return new Response();
    // }
}

