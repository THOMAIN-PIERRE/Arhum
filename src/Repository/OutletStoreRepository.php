<?php

namespace App\Repository;

use App\Entity\OutletStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OutletStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutletStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutletStore[]    findAll()
 * @method OutletStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutletStoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutletStore::class);
    }

    // /**
    //  * @return OutletStore[] Returns an array of OutletStore objects
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
    public function findOneBySomeField($value): ?OutletStore
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
