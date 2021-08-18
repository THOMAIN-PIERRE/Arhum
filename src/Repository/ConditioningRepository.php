<?php

namespace App\Repository;

use App\Entity\Conditioning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conditioning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conditioning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conditioning[]    findAll()
 * @method Conditioning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditioningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conditioning::class);
    }

    // /**
    //  * @return Conditioning[] Returns an array of Conditioning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conditioning
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
