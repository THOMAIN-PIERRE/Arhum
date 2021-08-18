<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
    * findSuccessOrders()
    *permet d'afficher les commandes dans l'espace membre de l'utilisateur
    */
    public function findSuccessOrders($user)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.state > 0')
            // ->andWhere('o.stripeSessionId > 0')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


    /**
    * findUserComments()
    *permet d'afficher tous les commentaires d'un client dans l'espace membre
    */
    public function findUserComments($user)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.comment > 0')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }


    // /**
    // * findSuccessOrders()
    // *permet d'afficher les commandes dans l'espace membre de l'utilisateur
    // */
    // public function findNumberOfSuccessOrders($user)
    // {
    //     return $this->createQueryBuilder('o')
    //         ->select('COUNT(o.id) as value')
    //         ->andWhere('o.state > 0')
    //         // ->andWhere('o.isPaid = 1')
    //         ->andWhere('o.user = :user')
    //         ->setParameter('user', $user)
    //         ->orderBy('o.id', 'DESC')
    //         ->getQuery()
    //         ->getScalarResult();
    // }


    /**
    * @return int|mixed|string|null
    */
    public function countAllOrders()
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder->select('COUNT(o.id) as value');

        return $queryBuilder->getQuery()->getSingleResult();
    }


    // /**
    // * Returns number of "commandes" per day
    // * @return void
    // */
    // public function countOrdersByDate()
    // {
    //     $queryBuilder = $this->createQueryBuilder('o')
    //                          ->select('SUBSTRING(o.createdAt, 1, 10) as dateCommandes, COUNT(o) as count')
                            //  ->andWhere('o.stripeSessionId != null')
    //                          ->groupBy('dateCommandes');

    //     return $queryBuilder->getQuery()->getResult();
    // }

    /**
    * Returns number of "commandes" per day
    * @return void
    */
    public function countConvertedOrders()
    {
        $queryBuilder = $this->createQueryBuilder('o')
                             ->select('COUNT(o.stripeSessionId) as convertedOrders');

        return $queryBuilder->getQuery()->getSingleResult();
    }



    /**
    * Returns number of "commandes" per day
    * @return void
    */
    public function countByDate()
    {
        $queryBuilder = $this->createQueryBuilder('o')
                             ->select('SUBSTRING(o.createdAt, 1, 10) as dateCommande, COUNT(o.stripeSessionId) as convertedOrders')
                            //  ->select('SUBSTRING(o.createdAt, 1, 10) as dateCommande, current_date() as date, COUNT(o.stripeSessionId) as convertedOrders')
                            //  ->where ('SUBSTRING(o.createdAt, 1, 10) = current_month()')
                            //  ->where ('MONTH(SUBSTRING(o.createdAt, 1, 10)) = current_month(date)')
                             ->groupBy('dateCommande');

        return $queryBuilder->getQuery()->getResult();
    }

}

