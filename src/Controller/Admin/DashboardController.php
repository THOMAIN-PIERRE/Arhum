<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\About;
use App\Entity\Order;
use App\Entity\Review;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Recipes;
use App\Entity\Carousel;
use App\Entity\Category;
use App\Entity\Partners;
use App\Entity\OpenHours;
use App\Entity\StatBlock;
use App\Entity\OutletStore;
use App\Entity\Conditioning;
use App\Service\StatsService;
use App\Entity\Characteristic;
use App\Entity\EcoCertification;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    protected $userRepository;
    protected $orderRepository;
    protected $productRepository;
    protected $orderDetailsRepository;
    protected $statsService;


    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, OrderRepository $orderRepository, OrderDetailsRepository $orderDetailsRepository, CategoryRepository $categRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->categoryRepository = $categRepository;
        // $this->StatsService = $statsService;

    }


    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();

         //on fait pointer notre fonction index() vers la vue que l'on veut lui donner
         return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            //Toutes les données que je déclare ici, je vais les retrouver dans mon front (= welcome.html.twig).
            'countAllUsers' => $this->userRepository->countAllUsers(),
            'users' => $this->userRepository->findAll(),
            'countAllProducts' => $this->productRepository->countAllProducts(),
            'countAllOrders' => $this->orderRepository->countAllOrders(),
            // 'weekSalesRevenue' => $this->orderDetailsRepository->weekSalesRevenue(),
            'totalSalesRevenue' => $this->orderDetailsRepository->totalSalesRevenue(),
            // 'countOrdersByDate' => $this->orderRepository->countOrdersByDate(),
            'countConvertedOrders' => $this->orderRepository->countConvertedOrders(),
            // 'sortByBirthday' => $this->userRepository->sortByBirthday(),
         ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/img/coco-tree.png"><span class="text-small" style="color: orange; font-size: 2rem;"> RHUMA SUG</span></a>')
            ->setFaviconPath('assets/img/favicon-coco-tree.ico');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class)
        // yield MenuItem::linktoDashboard('home', 'fa fa-home');
        yield MenuItem::linkToUrl('Dashboard', 'fas fa-tachometer-alt', '/stats');
        
        yield MenuItem::section('Section');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        // yield MenuItem::linkToCrud('Contact', 'fas fa-envelope', User::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Reviews', 'fa fa-comment', Review::class);
        yield MenuItem::linkToCrud('Conditioning', 'fas fa-wine-bottle', Conditioning::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-th-large', Category::class);
        yield MenuItem::linkToCrud('Characteristics', 'fas fa-list', Characteristic::class);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToUrl('', null ,'');
        yield MenuItem::linkToUrl('', null ,'');
        yield MenuItem::linkToCrud('About us', 'fas fa-industry', About::class);
        yield MenuItem::linkToCrud('Outlet Store', 'fas fa-store', OutletStore::class);
        yield MenuItem::linkToCrud('OpenHours', 'far fa-clock', OpenHours::class);
        // yield MenuItem::linkToCrud('News', 'fas fa-female', News::class);
        yield MenuItem::linkToCrud('Carousel', 'fas fa-images', Carousel::class);
        yield MenuItem::linkToCrud('Recipes', 'fas fa-mortar-pestle', Recipes::class);
        yield MenuItem::linkToCrud('StatBlock', 'fas fa-percentage', StatBlock::class);
        yield MenuItem::linkToCrud('EcoCertification', 'fas fa-globe-americas', EcoCertification::class);
        yield MenuItem::linkToCrud('Partners', 'fas fa-handshake', Partners::class);
        yield MenuItem::linkToUrl('', null ,'');
        yield MenuItem::linkToUrl('', null ,'');
        yield MenuItem::linkToUrl('Back to website', 'fas fa-undo-alt', '/');
        // yield MenuItem::linkToUrl('Dashboard', 'fas fa-tachometer-alt', '/stats');
        // yield MenuItem::linkToUrl('Dashboard Utils', 'fas fa-chart-bar', '/dashboard-utils');
        ;
    }


    public function dashboardAction(StatsService $statsService, CategoryRepository $categRepository, OrderRepository $orderRepository)
    {

        $bestProducts = $statsService->getProductsStats('DESC');
        $worstProducts = $statsService->getProductsStats('ASC');

        $bestRevenue = $statsService->getRevenueStats('DESC');
        $worstRevenue = $statsService->getRevenueStats('ASC');
        
        
        $displayUsers = $statsService->getUsersStats('ASC');
    


        $categories = $categRepository->findAll();

        $categName = [];
        $categColor = [];
        $categCount = [];

        foreach($categories as $category){
            $categName[] = $category->getName();
            $categColor[] = $category->getColor();
            $categCount[] = count($category->getProducts());
        }

        // On va chercher le nombre de commandes passées par date
        $commande = $orderRepository-> countOrdersByDate();

        // dd($commande);

        $dates = [];
        $commandesCount = [];

        foreach($commandes as $commande){
            $dates[] = $commande['dateCommandes'];
            $commandesCount[] = $commande['count'];
        }

        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'categName' => json_encode($categName),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),
                'dates' => json_encode($dates),
                'commandesCount' => json_encode($commandesCount),


                'bestProducts' => $bestProducts,
                'worstProducts' => $worstProducts,

        ]);


        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'bestProducts' => $bestProducts,
            'worstProducts' => $worstProducts,
            'bestRevenue' => $bestRevenue,
            'worstRevenue' => $worstRevenue,
            'displayUsers' => $displayUsers,

        ]);

            
    }

    
    public function statistiques(StatsService $statsService)
    {
        $bestProducts = $statsService->getProductsStats('DESC');
        $worstProducts = $statsService->getProductsStats('ASC');

        $bestRevenue = $statsService->getRevenueStats('DESC');
        $worstRevenue = $statsService->getRevenueStats('ASC');
        
        
        $displayUsers = $statsService->getUsersStats('ASC');

        // $totalAmount = $statsService->getTotalAmount();
        // $countOrders = $statsService->getCountOrders();


        

        //on fait pointer notre fonction index() vers la vue que l'on veut lui donner
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            

            'bestProducts' => $bestProducts,
            'worstProducts' => $worstProducts,
            'bestRevenue' => $bestRevenue,
            'worstRevenue' => $worstRevenue,
            'displayUsers' => $displayUsers,
            // 'totalAmount' => $totalAmount,
            // 'countOrders' => $countOrders,
            
           
            ]);
    }
    
}
