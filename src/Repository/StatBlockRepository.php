<?php

namespace App\Repository;

use App\Entity\StatBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatBlock[]    findAll()
 * @method StatBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatBlock::class);
    }

    // /**
    //  * @return StatBlock[] Returns an array of StatBlock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatBlock
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
