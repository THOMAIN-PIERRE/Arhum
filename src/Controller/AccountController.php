<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte", name="account")
     */
    public function index(StatsService $statsService): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getuser());

        // $addresses = $this->entityManager->getRepository(Address::class)->findAll();

        // $user = $this->getUser();

        // $nbOfAddress = $statsService->getCountAddresses();
        // $nbOfOrders = $statsService->getNbOfOrders();
        // $nbOfInProgressOrder = $statsService->getCountInProgressOrdersByUser();
        // $nbOfNullPayment = $statsService->getNumberOfNullPayment();

        

        return $this->render('account/index.html.twig', [
            'orders' => $orders,
            // 'addresses' => $addresses,
            // // 'user' => $user,
            // 'nbOfAddress' => $nbOfAddress,
            // 'nbOfOrders' => $nbOfOrders,
            // 'nbOfInProgressOrder' => $nbOfInProgressOrder,
            // 'nbOfNullPayment' => $nbOfNullPayment,
        ]);
    }
}
