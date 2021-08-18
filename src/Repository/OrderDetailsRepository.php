<?php

namespace App\Repository;

use App\Entity\OrderDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetails[]    findAll()
 * @method OrderDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetails::class);
    }

//     /**
//      * @return int|mixed|string|null
//      */
//     public function weekSalesRevenue()
//     {
//         $queryBuilder = $this->createQueryBuilder('o');
//         $queryBuilder->select('(SUM(o.total)/100) as value')
//                      ->join('ode')
//                      ->group by o
//                      ->order by value'
//                      )
    
//     return $queryBuilder->getQuery()->getSingleResult();
// }
//     }
    


    /**
     * @return int|mixed|string|null
     */
    public function totalSalesRevenue()
    {
            $queryBuilder = $this->createQueryBuilder('o');
            $queryBuilder->select('(SUM(o.total)/100) as value');
        
        return $queryBuilder->getQuery()->getSingleResult();
    }

    // /**
    // * findMOrderDetails()
    // *permet d'afficher les commandes dans l'espace membre de l'utilisateur
    // */
    // public function findMyOrderDetails($user)
    // {
    //     return $this->createQueryBuilder('d')
    //         ->andWhere('d.product > 0')
    //         // ->andWhere('o.isPaid = 1')
    //         // ->andWhere('d.user = :user')
    //         // ->setParameter('user', $user)
    //         ->orderBy('d.quantity', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }



    // public function totalProductsPrice(){
        // $queryBuilder = $this->createQueryBuilder('o');
        // $queryBuilder->select('count(o.total) as somme');

            // return $queryBuilder->getQuery()->getResult();
        
    // }
}












    // /**
    //  * @return OrderDetails[] Returns an array of OrderDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderDetails
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
